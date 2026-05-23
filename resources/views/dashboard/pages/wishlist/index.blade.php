@extends('dashboard.layouts.app')

@section('title', 'Properties Management')

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">WishList Properties</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">WishList Properties</li>
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

        <!-- Search and Filters -->

        <!-- Properties Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Property</th>
                                <th width="10%">Category</th>
                                <th width="10%">Type</th>
                                <th width="15%">Location</th>
                                <th width="12%">Price</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wishlists as $wishlist)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $wishlist->property->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="property-image">
                                            <img src="{{ $wishlist->property->featured_image_url }}"
                                                width="60" height="60"
                                                class="rounded-3 object-fit-cover"
                                                alt="{{ $wishlist->property->title }}">
                                        </div>
                                        <div class="property-info">
                                            {{ $wishlist->property->title }}
                                            <p class="mb-0 text-secondary small">Ref: {{ $wishlist->property->reference_number }}</p>
                                            <div class="property-details small text-muted">
                                                @if($wishlist->property->bedrooms)
                                                <span class="me-2"><i class="material-icons-outlined fs-6">bed</i> {{ $wishlist->property->bedrooms }}</span>
                                                @endif
                                                @if($wishlist->property->bathrooms)
                                                <span class="me-2"><i class="material-icons-outlined fs-6">bathroom</i> {{ $wishlist->property->bathrooms }}</span>
                                                @endif
                                                @if($wishlist->property->area_sqft)
                                                <span><i class="material-icons-outlined fs-6">square_foot</i> {{ number_format($wishlist->property->area_sqft) }} sqft</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $wishlist->property->category->name  }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $wishlist->property->type->name }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">
                                            @php
                                            $location = [];
                                            if ($wishlist->property->city) $location[] = $wishlist->property->city->name;
                                            if ($wishlist->property->state) $location[] = $wishlist->property->state->name;
                                            echo implode(', ', $location) ?: 'Location not set';
                                            @endphp
                                        </span>
                                        <small class="text-muted">{{ Str::limit($wishlist->property->address, 30) ?: 'No address' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-success">
                                            @php
                                            $formattedPrice = '$' . number_format($wishlist->property->price, 2);
                                            if ($wishlist->property->price_type === 'per_month') {
                                            $formattedPrice .= '/month';
                                            } elseif ($wishlist->property->price_type === 'negotiable') {
                                            $formattedPrice .= ' (Negotiable)';
                                            }
                                            @endphp
                                            {{ $formattedPrice }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('wishlist.show', $wishlist->property->id) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="View Details">
                                            <i class="material-icons-outlined">visibility</i>
                                        </a>
                                        <form action="{{ route('wishlist.destroy', $wishlist->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to remove this property from wishlist')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete Property">
                                                <i class="material-icons-outlined">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="material-icons-outlined fs-1 mb-3">home</i>
                                        <h6>No WishList Properties found</h6>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($wishlists->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-white">
                        Showing {{ $wishlists->firstItem() ?? 0 }} to {{ $wishlists->lastItem() ?? 0 }}
                        of {{ $wishlists->total() }} wishlists
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination round-pagination">
                            <li class="page-item {{ ($wishlists->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $wishlists->previousPageUrl() }}">Previous</a>
                            </li>
                            @for($i = 1; $i <= $wishlists->lastPage(); $i++)
                                <li class="page-item {{ ($wishlists->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $wishlists->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="page-item {{ ($wishlists->currentPage() == $wishlists->lastPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $wishlists->nextPageUrl() }}">Next</a>
                                </li>
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->

<style>
    .property-image img {
        object-fit: cover;
        border: 1px solid #e9ecef;
    }

    .property-title:hover {
        color: var(--bs-primary) !important;
    }

    .property-details .material-icons-outlined {
        font-size: 14px;
        vertical-align: middle;
    }

    .table> :not(caption)>*>* {
        padding: 1rem 0.75rem;
    }

    .badge {
        font-weight: 500;
    }

    .btn-sm {
        padding: 0.375rem 0.5rem;
    }

    .btn-sm .material-icons-outlined {
        font-size: 16px;
    }
</style>

<script>
    function toggleFeatured(propertyId) {
        fetch(`/admin/properties/${propertyId}/toggle-featured`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the property.');
            });
    }
</script>
@endsection