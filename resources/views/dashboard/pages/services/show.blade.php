@extends('dashboard.layouts.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Services</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Services</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Show Service
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-1 col-xl-1"></div>
            <div class="col-10 col-xl-10">
                <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">Service Details</h5>

                        <div class="row g-4">
                            <!-- Property Image -->
                            <div class="col-md-6">
                                <img src="{{ $property->image ? asset('storage/' . $property->image) : 'https://via.placeholder.com/600x400' }}"
                                    class="img-fluid rounded" alt="{{ $property->title }}">
                            </div>
                            <!-- Property Info -->
                            <div class="col-md-6">
                                <h3>{{ $property->title }}</h3>
                                <p><strong>Status:</strong>
                                    @if($property->status)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </p>
                                <ul class="list-unstyled mt-3">
                                    <li><strong>Category:</strong> {{ $property->category->name ?? '-' }}</li>
                                    <li><strong>Type:</strong> {{ $property->type->name ?? '-' }}</li>
                                    <li><strong>Created At:</strong> {{ $property->created_at->format('d M, Y h:i A') }}</li>
                                    <li><strong>Updated At:</strong> {{ $property->updated_at->format('d M, Y h:i A') }}</li>
                                </ul>
                                <div class="mt-4">
                                    <h5>Description</h5>
                                    <p>{{ $property->description }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1 col-xl-1"></div>
        </div>
    </div>
</main>

@endsection