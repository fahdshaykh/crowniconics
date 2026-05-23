@extends('dashboard.layouts.app')

@section('title', 'Role Details')

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
  <div class="main-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Authorization</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">Role Details</h5>
                    <p class="mb-0 text-secondary">View role information and assigned permissions</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary px-4">
                        <i class="material-icons-outlined">edit</i> Edit Role
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4">
                        <i class="material-icons-outlined">arrow_back</i> Back to Roles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Role Information</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $role->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td><span class="badge bg-primary">{{ $role->name }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Guard:</strong></td>
                            <td><span class="badge bg-secondary">{{ $role->guard_name }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $role->created_at->format('M d, Y H:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $role->updated_at->format('M d, Y H:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Statistics</h6>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $role->permissions->count() }}</h4>
                                <p class="text-muted mb-0">Permissions</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $role->users->count() }}</h4>
                            <p class="text-muted mb-0">Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Assigned Permissions</h6>
            @if($role->permissions->count() > 0)
                <div class="row">
                    @foreach($role->permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center p-2 border rounded">
                                <i class="material-icons-outlined text-success me-2">check_circle</i>
                                <span>{{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="material-icons-outlined">info</i>
                    No permissions assigned to this role.
                </div>
            @endif
        </div>
    </div>

    @if($role->users->count() > 0)
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Users with this Role</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
  </div>
</main>
<!--end main wrapper-->
@endsection
