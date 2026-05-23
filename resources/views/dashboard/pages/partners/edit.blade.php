@extends('dashboard.layouts.app')

@section('title', 'Edit Partner')

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Partners</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Partners</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Partner</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-xl-10 mx-auto">
                <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                    <div class="card-body p-4">
                        <h5 class="mb-3 fw-bold">Edit Partner</h5>

                        <form method="POST" action="{{ route('partners.update', $partner->id) }}" enctype="multipart/form-data" class="row g-4">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $partner->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Image -->
                            <div class="col-md-12">
                                <label for="image" class="form-label">Partner Image</label>
                                <input class="form-control @error('image') is-invalid @enderror"
                                       type="file" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($partner->image)
                                    <div class="mt-2">
                                        <small class="text-muted">Current Image:</small><br>
                                        <img src="{{ asset('storage/' . $partner->image) }}" 
                                             alt="partner" class="mt-1"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-12">
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-grd-primary px-4 text-white">Save</button>
                                    <a href="{{ route('partners.index') }}" class="btn btn-light px-4">Cancel</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
