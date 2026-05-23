@extends('dashboard.layouts.app')

@section('title', 'Subscription Usage')

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
  <div class="main-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Subscriptions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">My Subscriptions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usage</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Subscription Overview -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if($subscription->isOnTrial())
                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bx bx-time-five fs-4"></i>
                                </div>
                            @else
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bx bx-crown fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $subscription->plan->name }} Plan</h5>
                            <p class="text-muted mb-2">{{ $subscription->plan->description }}</p>
                            <div class="d-flex align-items-center gap-3">
                                <small class="text-muted">
                                    <i class="bx bx-calendar me-1"></i>
                                    @if($subscription->isOnTrial())
                                        Trial ends: {{ $subscription->trial_ends_at->format('M d, Y') }}
                                    @elseif($subscription->ends_at)
                                        Expires: {{ $subscription->ends_at->format('M d, Y') }}
                                    @else
                                        Active subscription
                                    @endif
                                </small>
                                <small class="text-muted">
                                    <i class="bx bx-credit-card me-1"></i>
                                    {{ ucfirst($subscription->billing_cycle->value) }} billing
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="mb-2">
                        <h4 class="text-primary mb-0">{{ $subscription->currency }} {{ number_format($subscription->amount, 2) }}</h4>
                        <small class="text-muted">per {{ $subscription->billing_cycle }}</small>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                        @if($subscription->isActive() && !$subscription->isOnTrial())
                            <form action="{{ route('subscriptions.cancel', $subscription) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to cancel your subscription?')">
                                    <i class="bx bx-x"></i> Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Statistics -->
    <div class="row mb-4">
        <!-- Property Listings -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bx bx-home display-4 text-primary"></i>
                    </div>
                    <h6 class="text-muted mb-2">Property Listings</h6>
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <span class="fs-3 fw-bold text-primary">{{ $subscription->properties_used }}</span>
                        @if($subscription->plan->hasUnlimitedProperties())
                            <span class="text-muted ms-2">/ Unlimited</span>
                        @else
                            <span class="text-muted ms-2">/ {{ $subscription->plan->property_listings }}</span>
                        @endif
                    </div>
                    @if(!$subscription->plan->hasUnlimitedProperties())
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ min(100, ($subscription->properties_used / $subscription->plan->property_listings) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">
                            {{ $subscription->remaining_properties }} remaining
                        </small>
                    @else
                        <small class="text-success">Unlimited listings</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Listings -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bx bx-star display-4 text-warning"></i>
                    </div>
                    <h6 class="text-muted mb-2">Featured Listings</h6>
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <span class="fs-3 fw-bold text-warning">{{ $subscription->featured_used }}</span>
                        @if($subscription->plan->featured_listings == -1)
                            <span class="text-muted ms-2">/ Unlimited</span>
                        @else
                            <span class="text-muted ms-2">/ {{ $subscription->plan->featured_listings }}</span>
                        @endif
                    </div>
                    @if($subscription->plan->featured_listings != -1)
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                 style="width: {{ min(100, ($subscription->featured_used / $subscription->plan->featured_listings) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">
                            {{ $subscription->remaining_featured }} remaining
                        </small>
                    @else
                        <small class="text-success">Unlimited featured listings</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Premium Listings -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bx bx-diamond display-4 text-success"></i>
                    </div>
                    <h6 class="text-muted mb-2">Premium Listings</h6>
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <span class="fs-3 fw-bold text-success">{{ $subscription->premium_used }}</span>
                        @if($subscription->plan->premium_listings == -1)
                            <span class="text-muted ms-2">/ Unlimited</span>
                        @else
                            <span class="text-muted ms-2">/ {{ $subscription->plan->premium_listings }}</span>
                        @endif
                    </div>
                    @if($subscription->plan->premium_listings != -1)
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ min(100, ($subscription->premium_used / $subscription->plan->premium_listings) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">
                            {{ max(0, $subscription->plan->premium_listings - $subscription->premium_used) }} remaining
                        </small>
                    @else
                        <small class="text-success">Unlimited premium listings</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Features -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bx bx-list-check me-2"></i>Plan Features</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Included Features</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($subscription->plan->hasUnlimitedProperties())
                                        Unlimited Property Listings
                                    @else
                                        {{ $subscription->plan->property_listings }} Property Listings
                                    @endif
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($subscription->plan->featured_listings == -1)
                                        Unlimited Featured Listings
                                    @else
                                        {{ $subscription->plan->featured_listings }} Featured Listings
                                    @endif
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($subscription->plan->premium_listings == -1)
                                        Unlimited Premium Listings
                                    @else
                                        {{ $subscription->plan->premium_listings }} Premium Listings
                                    @endif
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    {{ number_format($subscription->plan->storage_space_mb) }} MB Storage
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Additional Features</h6>
                            <ul class="list-unstyled">
                                @if($subscription->plan->analytics)
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Advanced Analytics
                                    </li>
                                @else
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-x-circle text-muted me-2"></i>
                                        <span class="text-muted">Advanced Analytics</span>
                                    </li>
                                @endif
                                @if($subscription->plan->support_priority)
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Priority Support
                                    </li>
                                @else
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-x-circle text-muted me-2"></i>
                                        <span class="text-muted">Priority Support</span>
                                    </li>
                                @endif
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Mobile Responsive Dashboard
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Easy Property Management
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bx bx-bolt me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($subscription->canListProperty())
                            <a href="{{ route('property.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i> List New Property
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="bx bx-plus me-1"></i> List New Property
                                <small class="d-block">Limit reached</small>
                            </button>
                        @endif

                        @if($subscription->canCreateFeatured())
                            <a href="{{ route('properties') }}" class="btn btn-warning">
                                <i class="bx bx-star me-1"></i> Create Featured Listing
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="bx bx-star me-1"></i> Create Featured Listing
                                <small class="d-block">Limit reached</small>
                            </button>
                        @endif

                        <a href="{{ route('properties') }}" class="btn btn-outline-primary">
                            <i class="bx bx-list-ul me-1"></i> Manage Properties
                        </a>

                        <a href="{{ route('subscriptions.plans') }}" class="btn btn-outline-success">
                            <i class="bx bx-upgrade me-1"></i> Upgrade Plan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Subscription Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Subscription Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Status:</strong><br>
                        <span class="badge {{ $subscription->isActive() ? 'bg-success' : ($subscription->isOnTrial() ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($subscription->status->value) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <strong>Billing Cycle:</strong><br>
                        <span class="badge bg-info">{{ ucfirst($subscription->billing_cycle->value) }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Amount:</strong><br>
                        <span class="fw-bold">{{ $subscription->currency }} {{ number_format($subscription->amount, 2) }}</span>
                    </div>
                    @if($subscription->days_until_expiration !== null)
                        <div class="mb-0">
                            <strong>Days Remaining:</strong><br>
                            <span class="badge {{ $subscription->days_until_expiration > 7 ? 'bg-success' : ($subscription->days_until_expiration > 3 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $subscription->days_until_expiration }} days
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
