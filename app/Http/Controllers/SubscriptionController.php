<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Enums\SubscriptionStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Display user's subscriptions
     */
    public function index()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions()->with('plan')->latest()->get();
        $activeSubscription = $user->getCurrentSubscription();

        return view('dashboard.pages.subscriptions', compact('subscriptions', 'activeSubscription'));
    }

    /**
     * Show subscription plans for user to choose
     */
    public function plans()
    {
        $plans = SubscriptionPlan::active()->orderBy('sort_order')->get();
        return view('dashboard.pages.subscription-plans-user', compact('plans'));
    }

    /**
     * Show subscription plan details
     */
    public function showPlan(SubscriptionPlan $plan)
    {
        return view('dashboard.pages.subscription-plan-details', compact('plan'));
    }

    /**
     * Subscribe to a plan
     */
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly',
            'phone_number' => 'required|string',
        ]);

        $user = Auth::user();

        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You already have an active subscription.');
        }

        // Validate phone number
        if (!$this->mpesaService->validatePhoneNumber($request->phone_number)) {
            return back()->withErrors(['phone_number' => 'Invalid phone number format. Use format: 07XXXXXXXX or +2547XXXXXXXX']);
        }

        // Calculate amount based on billing cycle
        $amount = $request->billing_cycle === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
        $amount += $plan->setup_fee;

        // Format phone number
        $phoneNumber = $this->mpesaService->formatPhoneNumber($request->phone_number);

        // Generate account reference
        $accountReference = config('mpesa.account_prefix') . '-' . $user->id . '-' . time();

        // Create pending subscription
        $subscription = DB::transaction(function () use ($user, $plan, $request, $amount, $phoneNumber, $accountReference) {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'billing_cycle' => $request->billing_cycle,
                'amount' => $amount,
                'currency' => $plan->currency,
                'status' => SubscriptionStatus::PENDING,
                'starts_at' => now(),
                'ends_at' => $this->calculateEndDate($request->billing_cycle, $plan->billing_cycle_days),
                'metadata' => [
                    'phone_number' => $request->phone_number,
                    'billing_cycle' => $request->billing_cycle,
                ]
            ]);

            // Create pending payment
            Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'payment_method' => 'mpesa',
                'amount' => $amount,
                'total_amount' => $amount,
                'currency' => $plan->currency,
                'status' => PaymentStatus::PENDING,
                'type' => PaymentType::SUBSCRIPTION,
                'billing_name' => $user->name,
                'billing_email' => $user->email,
                'billing_phone' => $request->phone_number,
                'mpesa_phone_number' => $phoneNumber,
                'mpesa_account_reference' => $accountReference,
                'mpesa_transaction_description' => "Subscription to {$plan->name}",
                'metadata' => [
                    'plan_id' => $plan->id,
                    'billing_cycle' => $request->billing_cycle,
                ]
            ]);

            return $subscription;
        });

        // Initiate M-Pesa STK Push
        $stkResult = $this->mpesaService->stkPush(
            $phoneNumber,
            $amount,
            $accountReference,
            "Subscription to {$plan->name}"
        );

        if ($stkResult['success']) {
            // Update payment with checkout request ID
            $payment = $subscription->payments()->latest()->first();
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'checkout_request_id' => $stkResult['checkout_request_id'],
                    'merchant_request_id' => $stkResult['merchant_request_id'],
                ])
            ]);

            return redirect()->route('subscriptions.payment-status', $subscription)
                ->with('success', 'Payment request sent to your phone. Please complete the payment.');
        } else {
            // Delete the subscription and payment if STK push failed
            $subscription->payments()->delete();
            $subscription->delete();

            return back()->withErrors(['payment' => $stkResult['message']]);
        }
    }

    /**
     * Show payment status page
     */
    public function paymentStatus(Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $subscription->payments()->latest()->first();
        
        return view('dashboard.pages.payment-status', compact('subscription', 'payment'));
    }

    /**
     * Check payment status via AJAX
     */
    public function checkPaymentStatus(Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $subscription->payments()->latest()->first();
        
        if (!$payment || !isset($payment->metadata['checkout_request_id'])) {
            return response()->json(['status' => 'error', 'message' => 'No payment found']);
        }

        // Query M-Pesa for transaction status
        $result = $this->mpesaService->queryStkPush($payment->metadata['checkout_request_id']);
        
        if ($result['success'] && isset($result['result_code']) && $result['result_code'] == 0) {
            // Payment successful - update subscription and payment
            DB::transaction(function () use ($subscription, $payment) {
                $subscription->update(['status' => SubscriptionStatus::ACTIVE]);
                $payment->update([
                    'status' => PaymentStatus::SUCCEEDED,
                    'paid_at' => now(),
                    'mpesa_receipt_number' => $result['mpesa_receipt_number'] ?? null,
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Payment completed successfully!',
                'redirect' => route('subscriptions.index')
            ]);
        }

        return response()->json(['status' => 'pending', 'message' => 'Payment is still being processed']);
    }

    /**
     * Cancel subscription
     */
    public function cancel(Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        if ($subscription->status !== 'active') {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Only active subscriptions can be canceled.');
        }

        $subscription->update([
            'status' => 'canceled',
            'canceled_at' => now(),
            'ends_at' => now(), // Immediate cancellation
        ]);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription canceled successfully.');
    }

    /**
     * Calculate subscription end date
     */
    private function calculateEndDate($billingCycle, $billingCycleDays)
    {
        if ($billingCycle === 'yearly') {
            return now()->addYear();
        }
        
        return now()->addDays($billingCycleDays);
    }

    /**
     * Show subscription usage
     */
    public function usage(Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription->load('plan');
        
        return view('dashboard.pages.subscription-usage', compact('subscription'));
    }
}
