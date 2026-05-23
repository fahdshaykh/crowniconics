@extends('dashboard.layouts.app')

@section('title', 'Subscription Plans')

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
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plans</li>
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

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="mb-3">Choose Your Perfect Plan</h2>
        <p class="text-muted">Select a subscription plan that fits your property listing needs</p>
    </div>

    <!-- Pricing Toggle -->
    <div class="text-center mb-4">
        <div class="btn-group" role="group" aria-label="Billing cycle toggle">
            <input type="radio" class="btn-check" name="billing-cycle" id="monthly" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="monthly">Monthly</label>

            <input type="radio" class="btn-check" name="billing-cycle" id="yearly" autocomplete="off">
            <label class="btn btn-outline-primary" for="yearly">Yearly <span class="badge bg-success ms-1">Save up to 20%</span></label>
        </div>
    </div>

    <!-- Subscription Plans -->
    <div class="row g-4">
        @foreach($plans as $plan)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 {{ $plan->is_popular ? 'border-warning shadow-lg' : '' }}">
                    @if($plan->is_popular)
                        <div class="card-header bg-warning text-dark text-center">
                            <span class="badge bg-dark">Most Popular</span>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-4">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="text-muted">{{ $plan->description }}</p>
                            
                            <div class="pricing">
                                <div class="monthly-price">
                                    <span class="display-4 fw-bold text-primary">{{ $plan->currency }} {{ number_format($plan->monthly_price, 0) }}</span>
                                    <span class="text-muted">/month</span>
                                </div>
                                <div class="yearly-price d-none">
                                    <span class="display-4 fw-bold text-success">{{ $plan->currency }} {{ number_format($plan->yearly_price, 0) }}</span>
                                    <span class="text-muted">/year</span>
                                    @if($plan->yearly_savings > 0)
                                        <div class="mt-2">
                                            <span class="badge bg-success">Save {{ $plan->yearly_savings }}%</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="flex-grow-1">
                            <h6 class="mb-3">What's included:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($plan->hasUnlimitedProperties())
                                        Unlimited Property Listings
                                    @else
                                        {{ $plan->property_listings }} Property Listings
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($plan->featured_listings == -1)
                                        Unlimited Featured Listings
                                    @else
                                        {{ $plan->featured_listings }} Featured Listings
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    @if($plan->premium_listings == -1)
                                        Unlimited Premium Listings
                                    @else
                                        {{ $plan->premium_listings }} Premium Listings
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    {{ number_format($plan->storage_space_mb) }} MB Storage
                                </li>
                                @if($plan->analytics)
                                    <li class="mb-2">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Advanced Analytics
                                    </li>
                                @endif
                                @if($plan->support_priority)
                                    <li class="mb-2">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Priority Support
                                    </li>
                                @endif
                                @if($plan->trial_days > 0)
                                    <li class="mb-2">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        {{ $plan->trial_days }}-Day Free Trial
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4">
                            <a href="{{ route('subscriptions.show-plan', $plan) }}" class="btn {{ $plan->is_popular ? 'btn-warning' : 'btn-outline-primary' }} w-100">
                                @if($plan->monthly_price == 0)
                                    <i class="bx bx-gift me-1"></i> Get Started Free
                                @else
                                    <i class="bx bx-crown me-1"></i> Choose Plan
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- FAQ Section -->
    <div class="card mt-5">
        <div class="card-header">
            <h5 class="mb-0"><i class="bx bx-help-circle me-2"></i>Frequently Asked Questions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Can I change my plan later?</h6>
                    <p class="text-muted">Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
                </div>
                <div class="col-md-6">
                    <h6>What payment methods do you accept?</h6>
                    <p class="text-muted">We accept M-Pesa payments through STK Push for all subscriptions.</p>
                </div>
                <div class="col-md-6">
                    <h6>Is there a free trial?</h6>
                    <p class="text-muted">Most plans come with a free trial period. Check the plan details for specific trial durations.</p>
                </div>
                <div class="col-md-6">
                    <h6>Can I cancel anytime?</h6>
                    <p class="text-muted">Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your billing period.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Pricing toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const monthlyRadio = document.getElementById('monthly');
    const yearlyRadio = document.getElementById('yearly');
    const monthlyPrices = document.querySelectorAll('.monthly-price');
    const yearlyPrices = document.querySelectorAll('.yearly-price');

    monthlyRadio.addEventListener('change', function() {
        if (this.checked) {
            monthlyPrices.forEach(price => price.classList.remove('d-none'));
            yearlyPrices.forEach(price => price.classList.add('d-none'));
        }
    });

    yearlyRadio.addEventListener('change', function() {
        if (this.checked) {
            monthlyPrices.forEach(price => price.classList.add('d-none'));
            yearlyPrices.forEach(price => price.classList.remove('d-none'));
        }
    });
});
</script>
@endsection
