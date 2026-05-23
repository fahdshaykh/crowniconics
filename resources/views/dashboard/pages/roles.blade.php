@extends('dashboard.layouts.app')

@section('title', 'Roles Management')

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
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Roles Management</h5>
                    <p class="mb-0 text-secondary">Manage user roles and their permissions</p>
                </div>
                

                 <div class="d-flex align-items-center gap-2 justify-content-lg-end" style="margin-bottom:10px">
                    <a href="{{ route('roles.create') }}" class="btn btn-outline-primary px-5"><i class="bi bi-plus-lg me-2"></i>Add Role</a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Role Name</th>
                            <th width="35%">Permissions</th>
                            <th width="15%">Users Count</th>
                            <th width="15%">Created</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $role->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="role-icon me-2">
                                            <i class="material-icons-outlined text-primary">admin_panel_settings</i>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary fs-6">{{ $role->name }}</span>
                                            <br>
                                            <small class="text-muted">{{ ucfirst($role->name) }} Role</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($role->permissions->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="badge bg-light text-dark fs-6">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="badge bg-secondary fs-6">+{{ $role->permissions->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">No permissions</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info fs-6 me-2">{{ $role->users_count ?? 0 }}</span>
                                        <small class="text-muted">users</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $role->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ $role->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <!-- <a href="{{ route('roles.show', $role) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="View Details">
                                            <i class="material-icons-outlined">visibility</i>
                                        </a> -->
                                        <a href="{{ route('roles.edit', $role) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit Role">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                        @if($role->users_count == 0)
                                            <form action="{{ route('roles.destroy', $role) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete Role">
                                                    <i class="material-icons-outlined">delete</i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    disabled 
                                                    title="Cannot delete - assigned to users">
                                                <i class="material-icons-outlined">delete</i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="material-icons-outlined fs-1 mb-3">admin_panel_settings</i>
                                        <h6>No roles found</h6>
                                        <p class="mb-0">Create your first role to get started</p>
                                        <a href="{{ route('roles.create') }}" class="btn btn-primary mt-2">
                                            <i class="material-icons-outlined">add</i> Create Role
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($roles->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-white">
                        Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} 
                        of {{ $roles->total() }} roles
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination round-pagination">
                            <li class="page-item {{ ($roles->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $roles->previousPageUrl() }}">Previous</a>
                            </li>
                            @for($i = 1; $i <= $roles->lastPage(); $i++)
                                <li class="page-item {{ ($roles->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $roles->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ ($roles->currentPage() == $roles->lastPage()) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $roles->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
  </div>
</main>
<!--end main wrapper-->

<style>
.role-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 6px;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.badge {
    font-weight: 500;
}

.btn-sm {
    padding: 0.375rem 0.5rem;
}

.btn-sm .material-icons-outlined {
    font-size: 16px;
}
</style>
@endsection
