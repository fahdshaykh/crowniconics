@extends('dashboard.layouts.app')
@section('title', 'Partners')
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
                        <li class="breadcrumb-item active" aria-current="page">Partners</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="row g-3">
            <div class="col-auto flex-grow-1 overflow-auto"></div>
            <div class="col-auto">
                <a href="{{ route('partners.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-lg me-2"></i>Add partner
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
                            @forelse($partners as $partner)
                            <tr>
                                <td>
                                    @if($partner->image)
                                    <img src="{{ asset('storage/'.$partner->image) }}" alt="partner" width="60" class="rounded">
                                    @else
                                    <img src="{{ asset('partners/partner-1.png') }}" alt="Default" width="60" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $partner->title }}</td>
                                <td>
                                    @if($partner->isActive())
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $partner->created_at->format('M d, Y h:i A') }}</td>


                                <td>
                                    <div class="d-flex gap-1">

                                        <a href="{{ route('partners.edit', $partner->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit Property">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                        <form action="{{ route('partner.toggle-status', $partner->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-{{ $partner->isActive() ? 'warning' : 'success' }}"
                                                title="{{ $partner->isActive() ? 'Deactivate' : 'Activate' }}">

                                                @if ($partner->isActive())
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
                                        <form action="{{ route('partners.destroy', $partner->id) }}"
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
                                <td colspan="7" class="text-center text-muted">No partners found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($partners->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Showing {{ $partners->firstItem() }} to {{ $partners->lastItem() }} of {{ $partners->total() }}
                    </div>
                    {{ $partners->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection