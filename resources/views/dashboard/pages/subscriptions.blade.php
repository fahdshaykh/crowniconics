@extends('dashboard.layouts.app')

@section('title', 'My Subscriptions')

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
                    <li class="breadcrumb-item active" aria-current="page">My Subscriptions</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Current Subscription Status -->
    @if($activeSubscription)
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @if($activeSubscription->isOnTrial())
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
                                <h5 class="mb-1">
                                    {{ $activeSubscription->plan->name }} Plan
                                    @if($activeSubscription->isOnTrial())
                                        <span class="badge bg-warning text-dark ms-2">Trial</span>
                                    @endif
                                </h5>
                                <p class="text-muted mb-2">{{ $activeSubscription->plan->description }}</p>
                                <div class="d-flex align-items-center gap-3">
                                    <small class="text-muted">
                                        <i class="bx bx-calendar me-1"></i>
                                        @if($activeSubscription->isOnTrial())
                                            Trial ends: {{ $activeSubscription->trial_ends_at->format('M d, Y') }}
                                        @elseif($activeSubscription->ends_at)
                                            Expires: {{ $activeSubscription->ends_at->format('M d, Y') }}
                                        @else
                                            Active subscription
                                        @endif
                                    </small>
                                    <small class="text-muted">
                                        <i class="bx bx-credit-card me-1"></i>
                                        {{ ucfirst($activeSubscription->billing_cycle->value) }} billing
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="mb-2">
                            <h4 class="text-primary mb-0">{{ $activeSubscription->currency }} {{ number_format($activeSubscription->amount, 2) }}</h4>
                            <small class="text-muted">per {{ $activeSubscription->billing_cycle }}</small>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('subscriptions.usage', $activeSubscription) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-bar-chart"></i> Usage
                            </a>
                            @if($activeSubscription->isActive() && !$activeSubscription->isOnTrial())
                                <form action="{{ route('subscriptions.cancel', $activeSubscription) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to cancel your subscription?')">
                                        <i class="bx bx-x"></i> Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Usage Stats -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h6 class="text-muted mb-1">Property Listings</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="fs-4 fw-bold text-primary">{{ $activeSubscription->properties_used }}</span>
                                @if($activeSubscription->plan->hasUnlimitedProperties())
                                    <span class="text-muted ms-2">/ Unlimited</span>
                                @else
                                    <span class="text-muted ms-2">/ {{ $activeSubscription->plan->property_listings }}</span>
                                @endif
                            </div>
                            @if(!$activeSubscription->plan->hasUnlimitedProperties())
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ min(100, ($activeSubscription->properties_used / $activeSubscription->plan->property_listings) * 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h6 class="text-muted mb-1">Featured Listings</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="fs-4 fw-bold text-warning">{{ $activeSubscription->featured_used }}</span>
                                @if($activeSubscription->plan->featured_listings == -1)
                                    <span class="text-muted ms-2">/ Unlimited</span>
                                @else
                                    <span class="text-muted ms-2">/ {{ $activeSubscription->plan->featured_listings }}</span>
                                @endif
                            </div>
                            @if($activeSubscription->plan->featured_listings != -1)
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ min(100, ($activeSubscription->featured_used / $activeSubscription->plan->featured_listings) * 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h6 class="text-muted mb-1">Premium Listings</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="fs-4 fw-bold text-success">{{ $activeSubscription->premium_used }}</span>
                                @if($activeSubscription->plan->premium_listings == -1)
                                    <span class="text-muted ms-2">/ Unlimited</span>
                                @else
                                    <span class="text-muted ms-2">/ {{ $activeSubscription->plan->premium_listings }}</span>
                                @endif
                            </div>
                            @if($activeSubscription->plan->premium_listings != -1)
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ min(100, ($activeSubscription->premium_used / $activeSubscription->plan->premium_listings) * 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Active Subscription -->
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bx bx-package display-1 text-muted"></i>
                </div>
                <h5 class="mb-3">No Active Subscription</h5>
                <p class="text-muted mb-4">Subscribe to a plan to start listing properties and access premium features.</p>
                <a href="{{ route('subscriptions.plans') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Browse Plans
                </a>
            </div>
        </div>
    @endif

    <!-- Subscription History -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bx bx-history me-2"></i>Subscription History</h6>
                <a href="{{ route('subscriptions.plans') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-plus"></i> Subscribe to Plan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Billing Cycle</th>
                                <th>Amount</th>
                                <th>Started</th>
                                <th>Expires</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $subscription->plan->name }}</h6>
                                            <small class="text-muted">{{ $subscription->plan->description }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($subscription->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @elseif($subscription->isOnTrial())
                                            <span class="badge bg-warning text-dark">Trial</span>
                                        @elseif($subscription->isExpired())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($subscription->isCanceled())
                                            <span class="badge bg-secondary">Canceled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($subscription->status->value) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($subscription->billing_cycle->value) }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $subscription->currency }} {{ number_format($subscription->amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $subscription->starts_at ? $subscription->starts_at->format('M d, Y') : 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('subscriptions.usage', $subscription) }}" class="btn btn-sm btn-outline-info" title="View Usage">
                                                <i class="bx bx-bar-chart"></i>
                                            </a>
                                            @if($subscription->isActive() && !$subscription->isOnTrial())
                                                <form action="{{ route('subscriptions.cancel', $subscription) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            title="Cancel Subscription"
                                                            onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bx bx-history display-4 text-muted"></i>
                    <p class="text-muted mt-2">No subscription history found</p>
                    <a href="{{ route('subscriptions.plans') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Subscribe to Plan
                    </a>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
