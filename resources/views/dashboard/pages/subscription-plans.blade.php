@extends('dashboard.layouts.app')
@section('title', 'Subscription Plans')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Subscription Plans</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription Plans</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <form action="{{ route('subscription-plans.index') }}" method="GET" class="mb-3">
                        <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name"
                            class="form-control px-5" />
                    </form>
                    <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto"></div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="{{ route('subscription-plan.create') }}" class="btn btn-outline-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i>Add Subscription Plan
                    </a>
                </div>
            </div>
        </div><!--end row-->

        <div class="card mt-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Plan Name</th>
                        <th>Slug</th>
                        <th>Monthly Price</th>
                        <th>Yearly Price</th>
                        <th>Property Listings</th>
                        <th>Featured Listings</th>
                        <th>Trial Days</th>
                        <th>Status</th>
                        <th>Popular</th>
                        <th>Sort Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    @if($plan->is_popular)
                                    <span class="badge bg-warning text-dark me-2">Popular</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $plan->name }}</h6>
                                    @if($plan->description)
                                    <small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <code>{{ $plan->slug }}</code>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $plan->currency }} {{ number_format($plan->monthly_price, 2) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $plan->currency }} {{ number_format($plan->yearly_price, 2) }}</span>
                            @if($plan->yearly_savings > 0)
                            <br><small class="text-success">Save {{ $plan->yearly_savings }}%</small>
                            @endif
                        </td>
                        <td>
                            @if($plan->hasUnlimitedProperties())
                            <span class="badge bg-success">Unlimited</span>
                            @else
                            <span class="badge bg-info">{{ $plan->property_listings }}</span>
                            @endif
                        </td>
                        <td>
                            @if($plan->featured_listings == -1)
                            <span class="badge bg-success">Unlimited</span>
                            @else
                            <span class="badge bg-warning text-dark">{{ $plan->featured_listings }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $plan->trial_days }} days</span>
                        </td>
                        <td>
                            <form action="{{ route('subscription-plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $plan->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            @if($plan->is_popular)
                            <span class="badge bg-warning text-dark">Yes</span>
                            @else
                            <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $plan->sort_order }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('subscription-plan.show', $plan->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-eye">
                                        <path d="M1 12s9-10 11-10 11 10 11 10-9 10-11 10-11-10-11-10z">
                                        </path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <form action="{{ route('subscription-plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $plan->is_active ? 'warning' : 'success' }}" title="{{ $plan->is_active ? 'Deactivate' : 'Activate' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-{{ $plan->is_active ? 'pause' : 'play' }}">
                                            @if($plan->is_active)
                                            <rect x="6" y="4" width="4" height="16"></rect>
                                            <rect x="14" y="4" width="4" height="16"></rect>
                                            @else
                                            <polygon points="5,3 19,12 5,21"></polygon>
                                            @endif
                                        </svg>
                                    </button>
                                </form>
                                <a href="{{ route('subscription-plan.edit', $plan->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('subscription-plan.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                            <polyline points="3,6 5,6 21,6"></polyline>
                                            <path d="M19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bx bx-package display-4"></i>
                                <p class="mt-2">No subscription plans found</p>
                                <a href="{{ route('subscription-plans.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Create First Plan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($plans->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $plans->links() }}
        </div>
        @endif
    </div>
    </div>
</main>
@endsection