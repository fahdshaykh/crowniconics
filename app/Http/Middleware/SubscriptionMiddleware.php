<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        // Admin users don't need subscriptions - they have full access
        if ($user->hasRole('admin')) {
            return $next($request);
        }
        // Check if user has active subscription
        if (!$user->hasActiveSubscription()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Active subscription required',
                    'message' => 'You need an active subscription to access this feature.',
                    'subscription_required' => true
                ], 403);
            }

            return redirect()->route('subscriptions.plans')
                ->with('error', 'You need an active subscription to access this feature.');
        }

        $subscription = $user->getCurrentSubscription();

        // Check specific feature if provided
        if ($feature) {
            switch ($feature) {
                case 'property_listing':
                    if (!$subscription->canListProperty()) {
                        if ($request->expectsJson()) {
                            return response()->json([
                                'error' => 'Property listing limit reached',
                                'message' => 'You have reached your property listing limit. Upgrade your plan to list more properties.',
                                'upgrade_required' => true
                            ], 403);
                        }

                        return redirect()->route('subscriptions.plans')
                            ->with('error', 'You have reached your property listing limit. Upgrade your plan to list more properties.');
                    }
                    break;

                case 'featured_listing':
                    if (!$subscription->canCreateFeatured()) {
                        if ($request->expectsJson()) {
                            return response()->json([
                                'error' => 'Featured listing limit reached',
                                'message' => 'You have reached your featured listing limit. Upgrade your plan to create more featured listings.',
                                'upgrade_required' => true
                            ], 403);
                        }

                        return redirect()->route('subscriptions.plans')
                            ->with('error', 'You have reached your featured listing limit. Upgrade your plan to create more featured listings.');
                    }
                    break;

                case 'analytics':
                    if (!$subscription->plan->analytics) {
                        if ($request->expectsJson()) {
                            return response()->json([
                                'error' => 'Analytics not available',
                                'message' => 'Analytics feature is not available in your current plan.',
                                'upgrade_required' => true
                            ], 403);
                        }

                        return redirect()->route('subscriptions.plans')
                            ->with('error', 'Analytics feature is not available in your current plan.');
                    }
                    break;
            }
        }

        return $next($request);
    }
}
