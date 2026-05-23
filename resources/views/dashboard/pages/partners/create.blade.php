@extends('dashboard.layouts.app')

@section('title', 'Create Partner')

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Partners</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('partners.index') }}">Partners</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Partner</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-1 col-xl-1"></div>
            <div class="col-10 col-xl-10">
                <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">Create Partner</h5>
                                <p class="mb-0 text-muted">Add a new partner entry</p>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="material-icons-outlined fs-5">more_vert</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('partners.index') }}">Back to Partners</a></li>
                                </ul>
                            </div>
                        </div>

                        <form class="row g-4" method="POST" action="{{ route('partners.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Enter partner title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-md-12">
                                <label for="image" class="form-label">Partner Image</label>
                                <input class="form-control @error('image') is-invalid @enderror"
                                       type="file" id="image" name="image" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Buttons -->
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-grd-primary px-4 text-white">Save</button>
                                    <a href="{{ route('partners.index') }}" class="btn btn-light px-4 ">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-1 col-xl-1"></div>
        </div>
    </div>
</main>
@endsection
