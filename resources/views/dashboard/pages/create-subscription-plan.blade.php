@extends('dashboard.layouts.app')

@section('title', isset($subscriptionPlan) ? 'Edit Subscription Plan' : 'Create Subscription Plan')

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
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($subscriptionPlan) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-0">{{ isset($subscriptionPlan) ? 'Edit Subscription Plan' : 'Create New Subscription Plan' }}</h5>
                        <p class="mb-0 text-secondary">{{ isset($subscriptionPlan) ? 'Update plan details and features' : 'Add a new subscription plan with features and pricing' }}</p>
                    </div>
                    <a href="{{ route('subscription-plans.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Back to Plans
                    </a>
                </div>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ isset($subscriptionPlan) ? route('subscription-plan.update', $subscriptionPlan) : route('subscription-plan.store') }}" method="POST">
                    @csrf
                    @if(isset($subscriptionPlan))
                    @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name"
                                                    value="{{ old('name', $subscriptionPlan->name ?? '') }}"
                                                    placeholder="e.g., Professional Plan" required>
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                    id="slug" name="slug"
                                                    value="{{ old('slug', $subscriptionPlan->slug ?? '') }}"
                                                    placeholder="e.g., professional-plan" required>
                                                @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="3"
                                            placeholder="Describe the plan features and benefits">{{ old('description', $subscriptionPlan->description ?? '') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bx bx-dollar me-2"></i>Pricing</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="monthly_price" class="form-label">Monthly Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control @error('monthly_price') is-invalid @enderror"
                                                        id="monthly_price" name="monthly_price"
                                                        value="{{ old('monthly_price', $subscriptionPlan->monthly_price ?? '') }}"
                                                        step="0.01" min="0" required>
                                                    <span class="input-group-text">KES</span>
                                                </div>
                                                @error('monthly_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="yearly_price" class="form-label">Yearly Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control @error('yearly_price') is-invalid @enderror"
                                                        id="yearly_price" name="yearly_price"
                                                        value="{{ old('yearly_price', $subscriptionPlan->yearly_price ?? '') }}"
                                                        step="0.01" min="0" required>
                                                    <span class="input-group-text">KES</span>
                                                </div>
                                                @error('yearly_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Features & Limits -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bx bx-list-check me-2"></i>Features & Limits</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="property_listings" class="form-label">Property Listings <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('property_listings') is-invalid @enderror"
                                                    id="property_listings" name="property_listings"
                                                    value="{{ old('property_listings', $subscriptionPlan->property_listings ?? '') }}"
                                                    min="-1" required>
                                                <small class="form-text text-muted">Use -1 for unlimited</small>
                                                @error('property_listings')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="featured_listings" class="form-label">Featured Listings <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('featured_listings') is-invalid @enderror"
                                                    id="featured_listings" name="featured_listings"
                                                    value="{{ old('featured_listings', $subscriptionPlan->featured_listings ?? '') }}"
                                                    min="-1" required>
                                                <small class="form-text text-muted">Use -1 for unlimited</small>
                                                @error('featured_listings')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="premium_listings" class="form-label">Premium Listings <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('premium_listings') is-invalid @enderror"
                                                    id="premium_listings" name="premium_listings"
                                                    value="{{ old('premium_listings', $subscriptionPlan->premium_listings ?? '') }}"
                                                    min="-1" required>
                                                @error('premium_listings')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Status & Settings -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bx bx-cog me-2"></i>Settings</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="trial_days" class="form-label">Trial Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('trial_days') is-invalid @enderror"
                                            id="trial_days" name="trial_days"
                                            value="{{ old('trial_days', $subscriptionPlan->trial_days ?? '0') }}"
                                            min="0" required>
                                        @error('trial_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="billing_cycle_days" class="form-label">Billing Cycle Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('billing_cycle_days') is-invalid @enderror"
                                            id="billing_cycle_days" name="billing_cycle_days"
                                            value="{{ old('billing_cycle_days', $subscriptionPlan->billing_cycle_days ?? '30') }}"
                                            min="1" required>
                                        @error('billing_cycle_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $subscriptionPlan->sort_order ?? '0') }}"
                                            min="0" required>
                                        @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bx bx-check-square me-2"></i>Features</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="analytics" name="analytics" value="1"
                                            {{ old('analytics', $subscriptionPlan->analytics ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="analytics">
                                            Analytics Dashboard
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="auto_renew" name="auto_renew" value="1"
                                            {{ old('auto_renew', $subscriptionPlan->auto_renew ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_renew">
                                            Auto Renewal
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $subscriptionPlan->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Plan
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" value="1"
                                            {{ old('is_popular', $subscriptionPlan->is_popular ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_popular">
                                            Popular Plan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-grd-primary px-4 text-white">
                                            Save
                                        </button>
                                        <a href="{{ route('subscription-plans.index') }}" class="btn btn-light px-4">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</main>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection