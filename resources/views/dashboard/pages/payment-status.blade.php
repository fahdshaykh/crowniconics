@extends('dashboard.layouts.app')

@section('title', 'Payment Status')

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
                    <li class="breadcrumb-item active" aria-current="page">Payment Status</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- Payment Status Header -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            @if($payment->status === App\Enums\PaymentStatus::SUCCEEDED)
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bx bx-check fs-1"></i>
                                </div>
                            @elseif($payment->status === App\Enums\PaymentStatus::FAILED)
                                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bx bx-x fs-1"></i>
                                </div>
                            @else
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bx bx-time-five fs-1"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h4 class="mb-2">
                            @if($payment->status === App\Enums\PaymentStatus::SUCCEEDED)
                                Payment Successful!
                            @elseif($payment->status === App\Enums\PaymentStatus::FAILED)
                                Payment Failed
                            @else
                                Payment Processing
                            @endif
                        </h4>
                        
                        <p class="text-muted">
                            @if($payment->status === App\Enums\PaymentStatus::SUCCEEDED)
                                Your subscription has been activated successfully.
                            @elseif($payment->status === App\Enums\PaymentStatus::FAILED)
                                There was an issue processing your payment. Please try again.
                            @else
                                Please complete the payment on your phone to activate your subscription.
                            @endif
                        </p>
                    </div>

                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Subscription Details</h6>
                                    <div class="mb-2">
                                        <strong>Plan:</strong> {{ $subscription->plan->name }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Billing Cycle:</strong> {{ ucfirst($subscription->billing_cycle->value) }}
                                    </div>
                                    <div class="mb-0">
                                        <strong>Amount:</strong> {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Payment Details</h6>
                                    <div class="mb-2">
                                        <strong>Status:</strong> 
                                        <span class="badge {{ $payment->status === App\Enums\PaymentStatus::SUCCEEDED ? 'bg-success' : ($payment->status === App\Enums\PaymentStatus::FAILED ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($payment->status->value) }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Method:</strong> M-Pesa
                                    </div>
                                    @if($payment->mpesa_receipt_number)
                                        <div class="mb-0">
                                            <strong>Receipt:</strong> {{ $payment->mpesa_receipt_number }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- M-Pesa Instructions -->
                    @if($payment->status === App\Enums\PaymentStatus::PENDING)
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="bx bx-info-circle me-2"></i>Complete Your Payment</h6>
                            <p class="mb-2">To complete your subscription, please:</p>
                            <ol class="mb-0">
                                <li>Check your phone for an M-Pesa STK Push notification</li>
                                <li>Enter your M-Pesa PIN when prompted</li>
                                <li>Wait for the payment confirmation</li>
                                <li>This page will automatically update once payment is received</li>
                            </ol>
                        </div>

                        <!-- Auto-refresh notice -->
                        <div class="text-center mb-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted mt-2">Checking payment status...</p>
                        </div>
                    @endif

                    <!-- Success Actions -->
                            @if($payment->status === App\Enums\PaymentStatus::SUCCEEDED)
                        <div class="text-center">
                            <a href="{{ route('subscriptions.index') }}" class="btn btn-primary me-2">
                                <i class="bx bx-check me-1"></i>View My Subscription
                            </a>
                            <a href="{{ route('properties') }}" class="btn btn-outline-primary">
                                <i class="bx bx-plus me-1"></i>Start Listing Properties
                            </a>
                        </div>
                    @endif

                    <!-- Failed Payment Actions -->
                    @if($payment->status === App\Enums\PaymentStatus::FAILED)
                        <div class="text-center">
                            <a href="{{ route('subscriptions.show-plan', $subscription->plan) }}" class="btn btn-primary me-2">
                                <i class="bx bx-refresh me-1"></i>Try Again
                            </a>
                            <a href="{{ route('subscriptions.plans') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Choose Different Plan
                            </a>
                        </div>
                    @endif

                    <!-- Pending Payment Actions -->
                    @if($payment->status === App\Enums\PaymentStatus::PENDING)
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-primary me-2" onclick="checkPaymentStatus()">
                                <i class="bx bx-refresh me-1"></i>Check Status
                            </button>
                            <a href="{{ route('subscriptions.plans') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Back to Plans
                            </a>
                        </div>
                    @endif

                    <!-- Troubleshooting -->
                    @if($payment->status === App\Enums\PaymentStatus::PENDING)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bx bx-help-circle me-2"></i>Need Help?</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Didn't receive the M-Pesa prompt?</h6>
                                        <ul class="list-unstyled">
                                            <li>• Check your phone's notification settings</li>
                                            <li>• Ensure your phone number is correct</li>
                                            <li>• Make sure you have sufficient M-Pesa balance</li>
                                            <li>• Try refreshing this page</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Payment issues?</h6>
                                        <ul class="list-unstyled">
                                            <li>• Contact M-Pesa support: *234#</li>
                                            <li>• Check your M-Pesa account balance</li>
                                            <li>• Ensure your M-Pesa PIN is correct</li>
                                            <li>• Try again after a few minutes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@if($payment->status === App\Enums\PaymentStatus::PENDING)
<script>
let checkInterval;

function checkPaymentStatus() {
    fetch('{{ route("subscriptions.check-payment", $subscription) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Payment successful, redirect
                window.location.href = data.redirect;
            } else if (data.status === 'error') {
                // Show error message
                alert(data.message);
            }
            // If still pending, continue checking
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        });
}

// Auto-check payment status every 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    checkInterval = setInterval(checkPaymentStatus, 5000);
    
    // Stop checking after 5 minutes
    setTimeout(() => {
        if (checkInterval) {
            clearInterval(checkInterval);
        }
    }, 300000);
});

// Manual check button
window.checkPaymentStatus = checkPaymentStatus;
</script>
@endif
@endsection
