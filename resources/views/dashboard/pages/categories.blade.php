@extends('dashboard.layouts.app')
@section('title', 'Categories')
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
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <form action="{{ route('categories.index') }}" method="GET" class="mb-3">
                        <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name"
                            class="form-control px-5" />
                    </form>
                    <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto"></div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    {{-- <a href="#" class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Export</a> --}}
                    <a href="{{ route('category.create') }}" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i>Add Category
                    </a>
                </div>
            </div>
        </div><!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <div class="category-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    {{-- <th><input class="form-check-input" type="checkbox"></th> --}}
                                    <th>Name</th>
                                    <th>Main Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="category-info">
                                                <a href="javascript:;" class="fw-bold">{{ $category->name }}</a>
                                                <p class="mb-0 text-secondary">{{ Str::limit($category->description, 40) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $category->mainCategory->name  ?? '-' }}</td>
                                    <td>

                                        @if($category->status->value)

                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('category.toggle-status', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-{{ $category->status === \App\Enums\BooleanEnum::TRUE ? 'warning' : 'success' }}"
                                                    title="{{ $category->status === \App\Enums\BooleanEnum::TRUE ? 'Deactivate' : 'Activate' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-{{ $category->status === \App\Enums\BooleanEnum::TRUE ? 'pause' : 'play' }}">
                                                        @if ($category->status === \App\Enums\BooleanEnum::TRUE)
                                                        <rect x="6" y="4" width="4" height="16"></rect>
                                                        <rect x="14" y="4" width="4" height="16"></rect>
                                                        @else
                                                        <polygon points="5,3 19,12 5,21"></polygon>
                                                        @endif
                                                    </svg>
                                                </button>
                                            </form>

                                            <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                    <path d="M1 12s9-10 11-10 11 10 11 10-9 10-11 10-11-10-11-10z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                                    <td colspan="6" class="text-center text-muted">No categories found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-white">
                            Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }}
                            of {{ $categories->total() }} categories
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination round-pagination">
                                <li class="page-item {{ ($categories->currentPage() == 1) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $categories->previousPageUrl() }}">Previous</a>
                                </li>
                                @for($i = 1; $i <= $categories->lastPage(); $i++)
                                    <li class="page-item {{ ($categories->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($categories->currentPage() == $categories->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $categories->nextPageUrl() }}">Next</a>
                                    </li>
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>

@endsection