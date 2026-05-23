@php
    $user = auth()->user();
    $subscription = $user ? $user->getCurrentSubscription() : null;
    $remainingProperties = $subscription ? $subscription->remaining_properties : 0;
    $remainingFeatured = $subscription ? $subscription->remaining_featured : 0;
@endphp

@if($subscription && $subscription->isActive())
    <div class="subscription-status bg-success text-white p-3 rounded mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">
                    <i class="fas fa-crown me-2"></i>
                    {{ $subscription->plan->name }} Plan
                </h6>
                <small>
                    @if($subscription->plan->hasUnlimitedProperties())
                        Unlimited Properties
                    @else
                        {{ $remainingProperties }} Properties Remaining
                    @endif
                    @if($remainingFeatured > 0)
                        • {{ $remainingFeatured }} Featured Remaining
                    @endif
                </small>
            </div>
            <div class="text-end">
                <small>
                    @if($subscription->ends_at)
                        Expires: {{ $subscription->ends_at->format('M d, Y') }}
                    @else
                        Active Subscription
                    @endif
                </small>
            </div>
        </div>
    </div>
@elseif($subscription && $subscription->isOnTrial())
    <div class="subscription-status bg-warning text-dark p-3 rounded mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">
                    <i class="fas fa-clock me-2"></i>
                    Trial Period - {{ $subscription->plan->name }}
                </h6>
                <small>
                    @if($subscription->plan->hasUnlimitedProperties())
                        Unlimited Properties
                    @else
                        {{ $remainingProperties }} Properties Remaining
                    @endif
                </small>
            </div>
            <div class="text-end">
                <small>
                    Trial ends: {{ $subscription->trial_ends_at->format('M d, Y') }}
                </small>
            </div>
        </div>
    </div>
@else
    <div class="subscription-status bg-danger text-white p-3 rounded mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    No Active Subscription
                </h6>
                <small>Subscribe to start listing properties</small>
            </div>
            <div>
                <a href="{{ route('subscriptions.plans') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>
                    Subscribe Now
                </a>
            </div>
        </div>
    </div>
@endif
