<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Enums\SubscriptionStatus;
use App\Enums\PaymentStatus;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MpesaCallbackController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Handle M-Pesa STK Push callback
     */
    public function stkCallback(Request $request)
    {
        try {
            Log::info('M-Pesa STK Callback Received', ['data' => $request->all()]);

            $callbackData = $this->mpesaService->parseCallbackData($request->getContent());
            
            if (!$callbackData) {
                Log::error('Failed to parse M-Pesa callback data');
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Failed to parse callback data']);
            }

            Log::info('Parsed M-Pesa Callback Data', $callbackData);

            // Find the payment by checkout request ID
            $payment = Payment::where('metadata->checkout_request_id', $callbackData['checkout_request_id'])->first();

            if (!$payment) {
                Log::error('Payment not found for checkout request ID', [
                    'checkout_request_id' => $callbackData['checkout_request_id']
                ]);
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Payment not found']);
            }

            // Update payment with M-Pesa details
            $payment->update([
                'mpesa_receipt_number' => $callbackData['mpesa_receipt_number'],
                'mpesa_transaction_id' => $callbackData['mpesa_receipt_number'],
                'mpesa_phone_number' => $callbackData['phone_number'],
                'metadata' => array_merge($payment->metadata ?? [], [
                    'transaction_date' => $callbackData['transaction_date'],
                    'result_code' => $callbackData['result_code'],
                    'result_description' => $callbackData['result_description'],
                ])
            ]);

            if ($callbackData['is_successful']) {
                // Payment successful
                DB::transaction(function () use ($payment, $callbackData) {
                    // Update payment status
                    $payment->update([
                        'status' => PaymentStatus::SUCCEEDED,
                        'paid_at' => now(),
                    ]);

                    // Update subscription status
                    if ($payment->subscription) {
                        $subscription = $payment->subscription;
                        $subscription->update([
                            'status' => SubscriptionStatus::ACTIVE,
                            'starts_at' => now(),
                        ]);

                        // If this is a renewal, update the end date
                        if ($subscription->billing_cycle === 'monthly') {
                            $subscription->update(['ends_at' => now()->addMonth()]);
                        } elseif ($subscription->billing_cycle === 'yearly') {
                            $subscription->update(['ends_at' => now()->addYear()]);
                        }

                        Log::info('Subscription activated', [
                            'subscription_id' => $subscription->id,
                            'user_id' => $subscription->user_id,
                            'plan_id' => $subscription->plan_id
                        ]);
                    }
                });

                Log::info('Payment processed successfully', [
                    'payment_id' => $payment->id,
                    'mpesa_receipt' => $callbackData['mpesa_receipt_number']
                ]);

                return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
            } else {
                // Payment failed
                $payment->update([
                    'status' => 'failed',
                    'failed_at' => now(),
                    'failure_message' => $callbackData['result_description'],
                ]);

                Log::info('Payment failed', [
                    'payment_id' => $payment->id,
                    'reason' => $callbackData['result_description']
                ]);

                return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
            }

        } catch (\Exception $e) {
            Log::error('M-Pesa Callback Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Internal server error']);
        }
    }

    /**
     * Handle M-Pesa timeout callback
     */
    public function timeoutCallback(Request $request)
    {
        Log::info('M-Pesa Timeout Callback Received', ['data' => $request->all()]);

        try {
            $callbackData = $this->mpesaService->parseCallbackData($request->getContent());
            
            if ($callbackData) {
                $payment = Payment::where('metadata->checkout_request_id', $callbackData['checkout_request_id'])->first();
                
                if ($payment) {
                    $payment->update([
                        'status' => 'failed',
                        'failed_at' => now(),
                        'failure_message' => 'Payment timeout',
                    ]);

                    Log::info('Payment marked as failed due to timeout', [
                        'payment_id' => $payment->id,
                        'checkout_request_id' => $callbackData['checkout_request_id']
                    ]);
                }
            }

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
        } catch (\Exception $e) {
            Log::error('M-Pesa Timeout Callback Error', [
                'message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Internal server error']);
        }
    }

    /**
     * Handle M-Pesa balance inquiry callback
     */
    public function balanceCallback(Request $request)
    {
        Log::info('M-Pesa Balance Callback Received', ['data' => $request->all()]);
        
        // This endpoint can be used for balance inquiry callbacks if needed
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}
