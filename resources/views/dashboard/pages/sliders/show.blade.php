@extends('dashboard.layouts.app')
@section('title', 'Slider Details')
@section('content')

<main class="main-wrapper">
    <div class="main-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sliders</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">Sliders</a></li>
                        <li class="breadcrumb-item active">Slider Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">{{ $slider->title }}</h5>

                <p><strong>Note:</strong> {{ $slider->note?? '-' }}</p>
                <p><strong>Description:</strong> {{ $slider->description ?? 'N/A' }}</p>
                <p><strong>Status:</strong>
                    @if($slider->status)
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-danger">Inactive</span>
                    @endif
                </p>
                <p><strong>Created At:</strong> {{ $slider->created_at->format('M d, Y h:i A') }}</p>

                @if($slider->image)
                <p><strong>Image:</strong></p>
                <img src="{{ asset('storage/'.$slider->image) }}" alt="Slider" width="300" class="rounded">
                @endif

                <div class="mt-4">
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection