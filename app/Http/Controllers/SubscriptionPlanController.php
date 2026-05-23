<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of subscription plans
     */
    public function index()
    {
        $search = request('name');
        $plans = SubscriptionPlan::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.pages.subscription-plans', compact('plans'));
    }

    /**
     * Show the form for creating a new subscription plan
     */
    public function create()
    {
        return view('dashboard.pages.create-subscription-plan');
    }

    /**
     * Store a newly created subscription plan
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            // 'currency' => 'required|string|size:3',
            'property_listings' => 'required|integer|min:-1',
            'featured_listings' => 'required|integer|min:0',
            'premium_listings' => 'required|integer|min:0',
            'analytics' => 'boolean',
            'trial_days' => 'required|integer|min:0',
            'billing_cycle_days' => 'required|integer|min:1',
            'auto_renew' => 'boolean',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        SubscriptionPlan::create($data);

        return redirect()->route('subscription-plans.index')->with('success', 'Subscription plan created successfully!');
    }

    /**
     * Display the specified subscription plan
     */
    public function show($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        $subscriptionPlan->load('subscriptions');
        return view('dashboard.pages.subscription-plan-show', compact('subscriptionPlan'));
    }

    /**
     * Show the form for editing the specified subscription plan
     */
    public function edit($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        return view('dashboard.pages.create-subscription-plan', compact('subscriptionPlan'));
    }

    /**
     * Update the specified subscription plan
     */
    public function update(Request $request, $id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $subscriptionPlan->id,
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            // 'currency' => 'required|string|size:3',
            'property_listings' => 'required|integer|min:-1',
            'featured_listings' => 'required|integer|min:0',
            'premium_listings' => 'required|integer|min:0',
            'analytics' => 'boolean',
            'trial_days' => 'required|integer|min:0',
            'billing_cycle_days' => 'required|integer|min:1',
            'auto_renew' => 'boolean',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $subscriptionPlan->update($data);

        return redirect()->route('subscription-plans.index')->with('success', 'Subscription plan updated successfully!');
    }

    /**
     * Remove the specified subscription plan
     */
    public function destroy($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);

        if ($subscriptionPlan->subscriptions()->count() > 0) {
            return redirect()->route('subscription-plans.index')
                ->with('error', 'Cannot delete plan. It has active subscriptions.');
        }

        $subscriptionPlan->delete();

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    /**
     * Toggle plan status
     */
    public function toggleStatus($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        $subscriptionPlan->update(['is_active' => !$subscriptionPlan->is_active]);

        $status = $subscriptionPlan->is_active ? 'activated' : 'deactivated';

        return redirect()->route('subscription-plans.index')
            ->with('success', "Plan {$status} successfully.");
    }

    /**
     * Display plans for users to subscribe
     */
    public function publicPlans()
    {
        $plans = SubscriptionPlan::active()->orderBy('sort_order')->get();
        return view('frontend.pages.subscription-plans', compact('plans'));
    }
}
