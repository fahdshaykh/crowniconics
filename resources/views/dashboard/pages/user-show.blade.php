@extends('dashboard.layouts.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Details</li>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">User Profile</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-2"></i>Edit User
                                </a>
                                <a href="{{ route('users') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Users
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="mb-4">
                                    <img src="{{ $user->profile_image_url }}" 
                                         alt="{{ $user->full_name }}" 
                                         class="rounded-circle" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <h4>{{ $user->full_name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                                
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'warning' : 'success') }} fs-6">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'inactive' ? 'danger' : 'warning') }} fs-6">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>

                                <div class="text-muted">
                                    <small>Member since {{ $user->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">First Name</label>
                                        <p class="form-control-plaintext">{{ $user->first_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Last Name</label>
                                        <p class="form-control-plaintext">{{ $user->last_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p class="form-control-plaintext">
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <p class="form-control-plaintext">{{ $user->phone ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Country</label>
                                        <p class="form-control-plaintext">{{ $user->country ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">City</label>
                                        <p class="form-control-plaintext">{{ $user->city ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">State</label>
                                        <p class="form-control-plaintext">{{ $user->state ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Zip Code</label>
                                        <p class="form-control-plaintext">{{ $user->zip_code ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Address</label>
                                        <p class="form-control-plaintext">{{ $user->address ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email Verified</label>
                                        <p class="form-control-plaintext">
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">Verified</span>
                                                <small class="text-muted d-block">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-warning">Not Verified</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <p class="form-control-plaintext">{{ $user->updated_at->format('M d, Y H:i') }}</p>
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

@endsection
