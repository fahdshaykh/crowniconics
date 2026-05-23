@extends('dashboard.layouts.app')

@section('title', 'Properties Management')

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Properties</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Properties</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Properties Management</h5>
                        <p class="mb-0 text-secondary">Manage all properties, listings, and real estate assets</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 justify-content-lg-end" style="margin-bottom:10px">
                        <a href="{{ route('property.create') }}" class="btn btn-outline-primary px-5"><i class="bi bi-plus-lg me-2"></i>Add Property</a>
                    </div>
                </div>
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
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('properties') }}" class="row g-3">
                    <div class="col-md-3">
                        <div class="position-relative">
                            <input class="form-control px-5" type="search" name="search"
                                placeholder="Search properties..."
                                value="{{ request('search') }}">
                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                            {{-- <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span> --}}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>
                                {{ ucfirst($name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($types ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ request('type') == $id ? 'selected' : '' }}>
                                {{ ucfirst($name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-2">
                        <select name="city" class="form-select">
                            <option value="">All Cities</option>
                            @foreach($cities ?? [] as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach($statuses ?? [] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="material-icons-outlined">filter_list</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
                                <th width="8%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($properties as $property)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $property->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="property-image">
                                            <img src="{{ $property->featured_image_url }}"
                                                width="60" height="60"
                                                class="rounded-3 object-fit-cover"
                                                alt="{{ $property->title }}">
                                        </div>
                                        <div class="property-info">
                                            <a href="{{ route('property.show', $property) }}"
                                                class="property-title fw-bold text-decoration-none">
                                                {{ $property->title }}
                                            </a>
                                            <p class="mb-0 text-secondary small">Ref: {{ $property->reference_number }}</p>
                                            <div class="property-details small text-muted">
                                                @if($property->beds)
                                                <span class="me-2"><i class="material-icons-outlined fs-6">bed</i> {{ $property->beds }}</span>
                                                @endif
                                                @if($property->bathrooms)
                                                <span class="me-2"><i class="material-icons-outlined fs-6">bathroom</i> {{ $property->bathrooms }}</span>
                                                @endif
                                                @if($property->area_sqft)
                                                <span><i class="material-icons-outlined fs-6">square_foot</i> {{ number_format($property->area_sqft) }} sqft</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $property->category->name  }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $property->type->name }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">
                                            @php
                                            $location = [];
                                            if ($property->city) $location[] = $property->city->name;
                                            if ($property->state) $location[] = $property->state->name;
                                            echo implode(', ', $location) ?: 'Location not set';
                                            @endphp
                                        </span>
                                        <small class="text-muted">{{ Str::limit($property->address, 30) ?: 'No address' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-success">
                                            @php
                                            $formattedPrice = '$' . number_format($property->price, 2);
                                            if ($property->price_type === 'per_month') {
                                            $formattedPrice .= '/month';
                                            } elseif ($property->price_type === 'negotiable') {
                                            $formattedPrice .= ' (Negotiable)';
                                            }
                                            @endphp
                                            {{ $formattedPrice }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        @php
                                        $badgeClass = $property->getStatusBadgeClass();
                                        @endphp

                                        <span class="badge {{ $badgeClass }} fs-6 dropdown-toggle"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="cursor: pointer;">
                                            {{ ucfirst($property->status) }}
                                        </span>

                                        <ul class="dropdown-menu">
                                            @foreach(['available' => 'bg-success', 'sold' => 'bg-danger', 'rented' => 'bg-info', 'pending' => 'bg-warning', 'draft' => 'bg-secondary'] as $status => $statusClass)
                                            @if($property->status !== $status)
                                            <li>
                                                <a class="dropdown-item change-status"
                                                    href="#"
                                                    data-property-id="{{ $property->id }}"
                                                    data-new-status="{{ $status }}">
                                                    <span class="badge {{ $statusClass }} me-2">{{ ucfirst($status) }}</span>
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if($property->is_featured)
                                    <br><small class="badge bg-warning text-dark mt-1">Featured</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('property.show', $property) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="View Details">
                                            <i class="material-icons-outlined">visibility</i>
                                        </a>
                                        <a href="{{ route('property.edit', $property) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit Property">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                        <form action="{{ route('property.destroy', $property) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this property?')">
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
                                        <h6>No properties found</h6>
                                        <p class="mb-0">Create your first property to get started</p>
                                        <a href="{{ route('property.create') }}" class="btn btn-primary mt-2">
                                            <i class="material-icons-outlined">add</i> Add Property
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($properties->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $properties->firstItem() ?? 0 }} to {{ $properties->lastItem() ?? 0 }}
                        of {{ $properties->total() }} properties
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination round-pagination">
                            <li class="page-item {{ ($properties->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $properties->previousPageUrl() }}">Previous</a>
                            </li>
                            @for($i = 1; $i <= $properties->lastPage(); $i++)
                                <li class="page-item {{ ($properties->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $properties->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="page-item {{ ($properties->currentPage() == $properties->lastPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $properties->nextPageUrl() }}">Next</a>
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

    .badge.dropdown-toggle {
        transition: all 0.3s ease;
        position: relative;
    }

    .badge.dropdown-toggle.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .badge.dropdown-toggle.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .dropdown-menu {
        min-width: auto;
        z-index: 1000;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    // Status change functionality
    document.querySelectorAll('.change-status').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const propertyId = this.getAttribute('data-property-id');
            const newStatus = this.getAttribute('data-new-status');
            if (confirm('Are you sure you want to change the status to ' + newStatus + '?')) {
                changePropertyStatus(propertyId, newStatus);
            }
        });
    });

    function changePropertyStatus(propertyId, newStatus) {
        // Quick CSRF token fix
        const csrfToken = '{{ csrf_token() }}';

        const clickedElement = document.querySelector(`a[data-property-id="${propertyId}"]`);
        const statusBadge = clickedElement.closest('td').querySelector('.badge.dropdown-toggle');

        const originalText = statusBadge.textContent;
        statusBadge.textContent = 'Updating...';

        fetch(`/admin/property/${propertyId}/change-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusBadge.textContent = data.new_status.charAt(0).toUpperCase() + data.new_status.slice(1);
                    statusBadge.className = `badge ${data.badge_class} fs-6 dropdown-toggle`;
                    showAlert('Status updated!', 'success');
                } else {
                    statusBadge.textContent = originalText;
                    showAlert('Failed to update status.', 'error');
                }
            })
            .catch(error => {
                statusBadge.textContent = originalText;
                showAlert('Error updating status.', 'error');
            });
    }

    function showAlert(message, type) {
        // You can use your existing alert system or create a simple one
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Prepend to the content area or use a specific alert container
        document.querySelector('.main-content').insertAdjacentHTML('afterbegin', alertHtml);

        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

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