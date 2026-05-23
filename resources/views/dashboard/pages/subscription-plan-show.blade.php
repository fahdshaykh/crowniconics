@extends('dashboard.layouts.app')

@section('title', 'Subscription Plan Details')

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
                        <li class="breadcrumb-item"><a href="{{ route('subscription-plans.index') }}">Subscription Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subscriptionPlan->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Plan Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-0">{{ $subscriptionPlan->name }}</h5>
                                <p class="mb-0 text-secondary">{{ $subscriptionPlan->description }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($subscriptionPlan->is_popular)
                                <span class="badge bg-warning text-dark">Popular</span>
                                @endif
                                <span class="badge {{ $subscriptionPlan->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $subscriptionPlan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Monthly Price</h6>
                                        <h4 class="text-primary">{{ $subscriptionPlan->currency }} {{ number_format($subscriptionPlan->monthly_price, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Yearly Price</h6>
                                        <h4 class="text-success">{{ $subscriptionPlan->currency }} {{ number_format($subscriptionPlan->yearly_price, 2) }}</h4>
                                        @if($subscriptionPlan->yearly_savings > 0)
                                        <small class="text-success">Save {{ $subscriptionPlan->yearly_savings }}%</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features & Limits -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="bx bx-list-check me-2"></i>Limits & Features</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td><strong>Property Listings:</strong></td>
                                                <td>
                                                    @if($subscriptionPlan->hasUnlimitedProperties())
                                                    <span class="badge bg-success">Unlimited</span>
                                                    @else
                                                    <span class="badge bg-info">{{ $subscriptionPlan->property_listings }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Featured Listings:</strong></td>
                                                <td>
                                                    @if($subscriptionPlan->featured_listings == -1)
                                                    <span class="badge bg-success">Unlimited</span>
                                                    @else
                                                    <span class="badge bg-warning text-dark">{{ $subscriptionPlan->featured_listings }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Premium Listings:</strong></td>
                                                <td>
                                                    @if($subscriptionPlan->premium_listings == -1)
                                                    <span class="badge bg-success">Unlimited</span>
                                                    @else
                                                    <span class="badge bg-primary">{{ $subscriptionPlan->premium_listings }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="bx bx-cog me-2"></i>Settings</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td><strong>Trial Days:</strong></td>
                                                <td><span class="badge bg-secondary">{{ $subscriptionPlan->trial_days }} days</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Billing Cycle:</strong></td>
                                                <td><span class="badge bg-primary">{{ $subscriptionPlan->billing_cycle_days }} days</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sort Order:</strong></td>
                                                <td><span class="badge bg-dark">{{ $subscriptionPlan->sort_order }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Analytics:</strong></td>
                                                <td>
                                                    @if($subscriptionPlan->analytics)
                                                    <span class="badge bg-success">Enabled</span>
                                                    @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Auto Renewal:</strong></td>
                                                <td>
                                                    @if($subscriptionPlan->auto_renew)
                                                    <span class="badge bg-success">Enabled</span>
                                                    @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-cog me-2"></i>Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('subscription-plan.edit', $subscriptionPlan) }}" class="btn btn-grd-primary px-4 text-white">
                                <i class="bx bx-edit"></i> Edit Plan
                            </a>
                            <a href="{{ route('subscription-plans.index') }}" class="btn btn-light px-4">
                                <i class="bx bx-arrow-back"></i> Back to Plans
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Subscription Statistics -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-bar-chart me-2"></i>Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary">{{ $subscriptionPlan->subscriptions()->count() }}</h4>
                                <small class="text-muted">Total Subscriptions</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">{{ $subscriptionPlan->activeSubscriptions()->count() }}</h4>
                                <small class="text-muted">Active Subscriptions</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plan Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Plan Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Slug:</strong><br>
                            <code>{{ $subscriptionPlan->slug }}</code>
                        </div>
                        <div class="mb-2">
                            <strong>Currency:</strong><br>
                            <span class="badge bg-info">{{ $subscriptionPlan->currency }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Created:</strong><br>
                            <small class="text-muted">{{ $subscriptionPlan->created_at->format('M d, Y H:i') }}</small>
                        </div>
                        <div class="mb-0">
                            <strong>Last Updated:</strong><br>
                            <small class="text-muted">{{ $subscriptionPlan->updated_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Subscriptions -->
        @if($subscriptionPlan->subscriptions()->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bx bx-users me-2"></i>Recent Subscriptions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Billing Cycle</th>
                                <th>Amount</th>
                                <th>Started</th>
                                <th>Expires</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptionPlan->subscriptions()->with('user')->latest()->limit(10)->get() as $subscription)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $subscription->user->profile_image_url }}"
                                                alt="{{ $subscription->user->name }}"
                                                class="rounded-circle" width="32" height="32">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">{{ $subscription->user->name }}</h6>
                                            <small class="text-muted">{{ $subscription->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $subscription->isActive() ? 'bg-success' : ($subscription->isOnTrial() ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ ucfirst($subscription->status->value) }}
                                    </span>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
</main>
@endsection