@extends('dashboard.layouts.app')
@section('title', 'Sliders')
@section('content')

<main class="main-wrapper">
    <div class="main-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sliders</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sliders</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="row g-3">
            <div class="col-auto flex-grow-1 overflow-auto"></div>
            <div class="col-auto">
                <a href="{{ route('sliders.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-lg me-2"></i>Add Slider
                </a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive white-space-nowrap">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                            <tr>
                                <td>
                                    @if($slider->image)
                                    <img src="{{ asset('storage/'.$slider->image) }}" alt="Slider" width="60" class="rounded">
                                    @else
                                    <img src="{{ asset('images/default-slider.jpg') }}" alt="Default" width="60" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>
                                    @if($slider->status)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $slider->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('sliders.show', $slider->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <form action="{{ route('slider.toggle-status', $slider->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="btn btn-sm btn-outline-{{ $slider->status? 'warning' : 'success' }}"
                                                title="{{ $slider->status ? 'Deactivate' : 'Activate' }}">
                                                Change Status
                                            </button>
                                        </form>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No sliders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sliders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Showing {{ $sliders->firstItem() }} to {{ $sliders->lastItem() }} of {{ $sliders->total() }}
                    </div>
                    {{ $sliders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection