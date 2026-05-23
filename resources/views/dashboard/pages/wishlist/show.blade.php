@extends('dashboard.layouts.app')

@section('title', $property->title)

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Wishlist</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('wishlist.index') }}">Wishlist</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $property->title }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                    <div class="card-body p-4">

                        <!-- Header with Actions -->
                        
                        <!-- Property Images Gallery -->
                        <div class="row g-4 mb-4">
                            <!-- Main Image -->
                            <div class="col-md-6">
                                <div class="property-main-image">
                                    <img src="{{ $property->featured_image_url }}"
                                        class="img-fluid rounded-3 w-100"
                                        alt="{{ $property->title }}"
                                        style="height: 300px; object-fit: cover;">
                                </div>
                                <!-- Additional Images -->
                                @if($property->hasImages() && count($property->images_urls) > 0)
                                <div class="mt-3">
                                    <h6>Additional Images ({{ count($property->images_urls) }})</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($property->images_urls as $index => $image)
                                        <img src="{{ $image }}"
                                            class="rounded-2 property-thumbnail"
                                            alt="Property Image {{ $index + 1 }}"
                                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;"
                                            onerror="this.src='{{ asset('images/default-property.jpg') }}'"
                                            onclick="changeMainImage(this)">
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Property Basic Info -->
                            <div class="col-md-6">
                                <div class="property-info">
                                    <h3 class="text-primary">{{ $property->title }}</h3>

                                    <!-- Location -->
                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <i class="bx bx-map me-2"></i>
                                        <span>
                                            @if($property->city)
                                            {{ $property->city->name }},
                                            @else
                                            {{ $property->city_id }},
                                            @endif
                                            @if($property->state)
                                            {{ $property->state->name }},
                                            @endif
                                            @if($property->country)
                                            {{ $property->country->name }}
                                            @else
                                            {{ $property->country_id }}
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Price -->
                                    <div class="price-section mb-3">
                                        <h4 class="text-success mb-1">
                                            ${{ number_format($property->price) }}
                                            <small class="text-muted fs-6">
                                                @if($property->price_type === 'per_month')
                                                /month
                                                @elseif($property->price_type === 'negotiable')
                                                (Negotiable)
                                                @else
                                                (Fixed)
                                                @endif
                                            </small>
                                        </h4>
                                    </div>

                                    <!-- Property Features Grid -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <div class="feature-item text-center p-2 border rounded-2">
                                                <i class="bx bx-bed fs-4 text-primary"></i>
                                                <div class="mt-1">
                                                    <strong>{{ $property->beds ?? '0' }}</strong>
                                                    <div class="text-muted small">Beds</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="feature-item text-center p-2 border rounded-2">
                                                <i class="bx bx-bath fs-4 text-primary"></i>
                                                <div class="mt-1">
                                                    <strong>{{ $property->bathrooms ?? '0' }}</strong>
                                                    <div class="text-muted small">Baths</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="feature-item text-center p-2 border rounded-2">
                                                <i class="bx bx-car fs-4 text-primary"></i>
                                                <div class="mt-1">
                                                    <strong>{{ $property->parking ?? '0' }}</strong>
                                                    <div class="text-muted small">Parking</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="feature-item text-center p-2 border rounded-2">
                                                <i class="bx bx-area fs-4 text-primary"></i>
                                                <div class="mt-1">
                                                    <strong>{{ number_format($property->area_sqft) }}</strong>
                                                    <div class="text-muted small">Sq Ft</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="mb-3">
                                        <span class="badge 
                                                @if($property->status === 'available') bg-success
                                                @elseif($property->status === 'sold') bg-danger
                                                @elseif($property->status === 'rented') bg-info
                                                @elseif($property->status === 'pending') bg-warning
                                                @else bg-secondary @endif">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                        @if($property->is_featured)
                                        <span class="badge bg-primary ms-1">Featured</span>
                                        @endif
                                    </div>

                                    <!-- Category & Type -->
                                    <div class="property-meta">
                                        <p class="mb-1">
                                            <strong>Category:</strong>
                                            <span class="text-muted">{{ $property->category->name ?? 'N/A' }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <strong>Type:</strong>
                                            <span class="text-muted">{{ $property->type->name ?? 'N/A' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bx bx-detail me-2"></i>Description</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $property->description ?? 'No description available.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features & Amenities -->
                        <div class="row g-4 mt-2">
                            <!-- Features -->
                            @php
                            $features = $property->features ? explode(',', $property->features) : [];
                            @endphp

                            @if(!empty($features))
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bx bx-star me-2"></i>Features</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($features as $feature)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                                {{ ucfirst(trim($feature)) }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Agent Information -->
                            @if($property->agent)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bx bx-user me-2"></i>Contact Agent</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $property->agent->name }}</h6>
                                                <p class="text-muted small mb-2">
                                                    <i class="bx bx-envelope me-1"></i>{{ $property->agent->email }}
                                                </p>
                                                @if($property->agent->phone)
                                                <p class="text-muted small mb-3">
                                                    <i class="bx bx-phone me-1"></i>{{ $property->agent->phone }}
                                                </p>
                                                @endif
                                                <div class="d-flex gap-2">
                                                    @if($property->agent->phone)
                                                    <a href="tel:{{ $property->agent->phone }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="bx bx-phone"></i> Call
                                                    </a>
                                                    @endif
                                                    <a href="mailto:{{ $property->agent->email }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bx bx-envelope"></i> Email
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Additional Details -->
                        <div class="row g-4 mt-2">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Additional Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <strong>Reference No:</strong>
                                                <br>
                                                <span class="text-muted">{{ $property->reference_number ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>ZIP Code:</strong>
                                                <br>
                                                <span class="text-muted">{{ $property->zip_code ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Address:</strong>
                                                <br>
                                                <span class="text-muted">{{ $property->address ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this property? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>

<style>
    .feature-item {
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .property-main-image img {
        transition: transform 0.3s ease;
    }

    .property-main-image img:hover {
        transform: scale(1.02);
    }
</style>
@endsection