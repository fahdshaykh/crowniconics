@extends('dashboard.layouts.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('categories.index') }}">Categories</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

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

        <div class="row">
            <div class="col-1 col-xl-1"></div>
            <div class="col-10 col-xl-10">
                <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <h5 class="mb-0 fw-bold">{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h5>
                            <div class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="material-icons-outlined fs-5">more_vert</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('categories.index') }}">Back to Categories</a></li>
                                    <li><a class="dropdown-item" href="{{ route('category.create') }}">Create New Category</a></li>
                                </ul>
                            </div>
                        </div>

                        <form class="row g-4" method="POST" action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if(isset($category))
                            @method('PUT')
                            @endif

                            <div class="col-md-12">
                                <label for="status" class="form-label">Select Type</label>
                                <select id="status" name="main_category_id" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Choose...</option>
                                    <option value="1" {{ old('status', $category->main_category_id ?? '') == '1' ? 'selected' : '' }}>Property</option>
                                    <option value="2" {{ old('status', $category->main_category_id ?? '') == '2' ? 'selected' : '' }}>Service</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name"
                                    value="{{ old('name', $category->name ?? '') }}"
                                    placeholder="Enter category name" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description"
                                    rows="4" placeholder="Enter category description">{{ old('description', $category->description ?? '') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-grd-primary px-4 text-white">
                                        Save
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-light px-4">Cancel</a>
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