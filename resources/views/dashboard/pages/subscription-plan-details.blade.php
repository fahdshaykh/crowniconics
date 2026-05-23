@extends('dashboard.layouts.app')

@section('title', 'Plan Details - ' . $plan->name)

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
                    <li class="breadcrumb-item"><a href="{{ route('subscriptions.plans') }}">Plans</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $plan->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Plan Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($plan->is_popular)
                            <div class="mb-3">
                                <span class="badge bg-warning text-dark fs-6">Most Popular</span>
                            </div>
                        @endif
                        <h2 class="mb-3">{{ $plan->name }}</h2>
                        <p class="text-muted fs-5">{{ $plan->description }}</p>
                    </div>

                    <!-- Pricing -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Monthly</h6>
                                    <h3 class="text-primary mb-1">{{ $plan->currency }} {{ number_format($plan->monthly_price, 2) }}</h6>
                                    <small class="text-muted">per month</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Yearly</h6>
                                    <h3 class="text-success mb-1">{{ $plan->currency }} {{ number_format($plan->yearly_price, 2) }}</h6>
                                    <small class="text-muted">per year</small>
                                    @if($plan->yearly_savings > 0)
                                        <div class="mt-2">
                                            <span class="badge bg-success">Save {{ $plan->yearly_savings }}%</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="bx bx-list-check me-2"></i>What's Included</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>
                                            @if($plan->hasUnlimitedProperties())
                                                Unlimited Property Listings
                                            @else
                                                {{ $plan->property_listings }} Property Listings
                                            @endif
                                        </strong>
                                        <br>
                                        <small class="text-muted">List your properties and reach potential buyers</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>
                                            @if($plan->featured_listings == -1)
                                                Unlimited Featured Listings
                                            @else
                                                {{ $plan->featured_listings }} Featured Listings
                                            @endif
                                        </strong>
                                        <br>
                                        <small class="text-muted">Highlight your best properties for maximum visibility</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>
                                            @if($plan->premium_listings == -1)
                                                Unlimited Premium Listings
                                            @else
                                                {{ $plan->premium_listings }} Premium Listings
                                            @endif
                                        </strong>
                                        <br>
                                        <small class="text-muted">Premium placement for your top properties</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>{{ number_format($plan->storage_space_mb) }} MB Storage</strong>
                                        <br>
                                        <small class="text-muted">Store property images and documents</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="bx bx-star me-2"></i>Additional Features</h5>
                            <ul class="list-unstyled">
                                @if($plan->analytics)
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                        <div>
                                            <strong>Advanced Analytics</strong>
                                            <br>
                                            <small class="text-muted">Track views, inquiries, and performance metrics</small>
                                        </div>
                                    </li>
                                @endif
                                @if($plan->support_priority)
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                        <div>
                                            <strong>Priority Support</strong>
                                            <br>
                                            <small class="text-muted">Get help faster with priority customer support</small>
                                        </div>
                                    </li>
                                @endif
                                @if($plan->trial_days > 0)
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                        <div>
                                            <strong>{{ $plan->trial_days }}-Day Free Trial</strong>
                                            <br>
                                            <small class="text-muted">Try all features risk-free</small>
                                        </div>
                                    </li>
                                @endif
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>Mobile Responsive</strong>
                                        <br>
                                        <small class="text-muted">Access your dashboard from any device</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="bx bx-check-circle text-success me-3 fs-5"></i>
                                    <div>
                                        <strong>Easy Management</strong>
                                        <br>
                                        <small class="text-muted">Simple dashboard to manage all your listings</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Subscribe Form -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bx bx-crown me-2"></i>Subscribe to {{ $plan->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST" id="subscribeForm">
                        @csrf
                        
                        <!-- Billing Cycle Selection -->
                        <div class="mb-4">
                            <label class="form-label">Choose Billing Cycle</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="billing_cycle" id="monthly" value="monthly" checked>
                                <label class="btn btn-outline-primary" for="monthly">
                                    Monthly<br>
                                    <small>{{ $plan->currency }} {{ number_format($plan->monthly_price, 2) }}</small>
                                </label>

                                <input type="radio" class="btn-check" name="billing_cycle" id="yearly" value="yearly">
                                <label class="btn btn-outline-success" for="yearly">
                                    Yearly<br>
                                    <small>{{ $plan->currency }} {{ number_format($plan->yearly_price, 2) }}</small>
                                    @if($plan->yearly_savings > 0)
                                        <br><span class="badge bg-success">Save {{ $plan->yearly_savings }}%</span>
                                    @endif
                                </label>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label for="phone_number" class="form-label">M-Pesa Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" name="phone_number" 
                                   value="{{ old('phone_number') }}" 
                                   placeholder="07XXXXXXXX or +2547XXXXXXXX" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Enter your M-Pesa registered phone number</small>
                        </div>

                        <!-- Total Amount Display -->
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between">
                                <span>Total Amount:</span>
                                <strong id="totalAmount">{{ $plan->currency }} {{ number_format($plan->monthly_price + $plan->setup_fee, 2) }}</strong>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bx bx-credit-card me-2"></i>
                            Subscribe with M-Pesa
                        </button>

                        <!-- Terms -->
                        <div class="text-center">
                            <small class="text-muted">
                                By subscribing, you agree to our 
                                <a href="#" class="text-primary">Terms of Service</a> and 
                                <a href="#" class="text-primary">Privacy Policy</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Plan Comparison -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bx bx-bar-chart me-2"></i>Why Choose This Plan?</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @if($plan->is_popular)
                            <li class="mb-2">
                                <i class="bx bx-star text-warning me-2"></i>
                                Most popular choice
                            </li>
                        @endif
                        @if($plan->trial_days > 0)
                            <li class="mb-2">
                                <i class="bx bx-gift text-success me-2"></i>
                                {{ $plan->trial_days }}-day free trial
                            </li>
                        @endif
                        @if($plan->yearly_savings > 0)
                            <li class="mb-2">
                                <i class="bx bx-dollar text-success me-2"></i>
                                Save {{ $plan->yearly_savings }}% with yearly billing
                            </li>
                        @endif
                        <li class="mb-2">
                            <i class="bx bx-shield text-primary me-2"></i>
                            Cancel anytime
                        </li>
                        <li class="mb-0">
                            <i class="bx bx-support text-info me-2"></i>
                            @if($plan->support_priority)
                                Priority support included
                            @else
                                Email support included
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-4">
                <a href="{{ route('subscriptions.plans') }}" class="btn btn-outline-secondary w-100">
                    <i class="bx bx-arrow-back me-2"></i>Back to All Plans
                </a>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyRadio = document.getElementById('monthly');
    const yearlyRadio = document.getElementById('yearly');
    const totalAmountElement = document.getElementById('totalAmount');
    
    const monthlyPrice = {{ $plan->monthly_price }};
    const yearlyPrice = {{ $plan->yearly_price }};
    const setupFee = {{ $plan->setup_fee }};
    const currency = '{{ $plan->currency }}';

    function updateTotalAmount() {
        let price = monthlyRadio.checked ? monthlyPrice : yearlyPrice;
        let total = price + setupFee;
        totalAmountElement.textContent = currency + ' ' + total.toFixed(2);
    }

    monthlyRadio.addEventListener('change', updateTotalAmount);
    yearlyRadio.addEventListener('change', updateTotalAmount);

    // Form validation
    document.getElementById('subscribeForm').addEventListener('submit', function(e) {
        const phoneNumber = document.getElementById('phone_number').value;
        
        // Basic phone number validation
        if (!phoneNumber || phoneNumber.length < 9) {
            e.preventDefault();
            alert('Please enter a valid phone number');
            return false;
        }
        
        // Confirm subscription
        if (!confirm('Are you sure you want to subscribe to this plan? You will be redirected to M-Pesa for payment.')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection
