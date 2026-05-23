@extends('dashboard.layouts.app')

@section('title', 'Services Management')

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Services</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Services Management</h5>
                        <p class="mb-0 text-secondary">Manage all Services, listings, and real estate assets</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 justify-content-lg-end" style="margin-bottom:10px">
                        <a href="{{ route('services.create') }}" class="btn btn-outline-primary px-5"><i class="bi bi-plus-lg me-2"></i>Add Service</a>
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
                <form method="GET" action="{{ route('services.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <div class="position-relative">
                            <input class="form-control px-5" type="search" name="search"
                                placeholder="Search services..."
                                value="{{ request('search') }}">
                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                            {{-- <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span> --}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>
                                {{ ucfirst($name) }}
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

        <!-- Services Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Title</th>
                                <th width="25%">Category</th>
                                <th width="25%">Type</th>
                                <th width="8%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $service->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="service-image">
                                            <img src="{{ $service->service_image }}"
                                                width="60" height="60"
                                                class="rounded-3 object-fit-cover">
                                        </div>
                                        <div class="service-info">
                                            {{ $service->title }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $service->category->name  }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $service->type->name }}</span>
                                </td>
                                <td>
                                    @if($service->isActive())
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('services.edit', $service) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit service">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                        <form action="{{ route('service.toggle-status', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-{{ $service->isActive() ? 'warning' : 'success' }}"
                                                title="{{ $service->isActive() ? 'Deactivate' : 'Activate' }}">

                                                @if ($service->isActive())
                                                <!-- Pause icon (active) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-pause">
                                                    <rect x="6" y="4" width="4" height="16"></rect>
                                                    <rect x="14" y="4" width="4" height="16"></rect>
                                                </svg>
                                                @else
                                                <!-- Play icon (inactive) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-play">
                                                    <polygon points="5,3 19,12 5,21"></polygon>
                                                </svg>
                                                @endif
                                            </button>
                                        </form>


                                        <a href="{{ route('service.show', $service->id) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                <path d="M1 12s9-10 11-10 11 10 11 10-9 10-11 10-11-10-11-10z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        <form action="{{ route('services.destroy', $service) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete service">
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
                                        <h6>No Services found</h6>
                                        <p class="mb-0">Create your first service to get started</p>
                                        <a href="{{ route('services.create') }}" class="btn btn-primary mt-2">
                                            <i class="material-icons-outlined">add</i> Add service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($services->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-white">
                        Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }}
                        of {{ $services->total() }} services
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination round-pagination">
                            <li class="page-item {{ ($services->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $services->previousPageUrl() }}">Previous</a>
                            </li>
                            @for($i = 1; $i <= $services->lastPage(); $i++)
                                <li class="page-item {{ ($services->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $services->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="page-item {{ ($services->currentPage() == $services->lastPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $services->nextPageUrl() }}">Next</a>
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
        fetch(`/admin/services/${propertyId}/toggle-featured`, {
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