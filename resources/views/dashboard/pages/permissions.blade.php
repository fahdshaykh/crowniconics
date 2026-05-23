@extends('dashboard.layouts.app')

@section('title', 'Permissions Management')

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
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Permissions Management</h5>
                    <p class="mb-0 text-secondary">Manage system permissions and their assignments</p>
                </div>
                     <div class="d-flex align-items-center gap-2 justify-content-lg-end" style="margin-bottom:10px">
                    <a href="{{ route('permissions.create') }}" class="btn btn-outline-primary px-5"><i class="bi bi-plus-lg me-2"></i>Add Permission</a>
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
                            <th width="25%">Permission Name</th>
                            <th width="15%">Guard</th>
                            <th width="15%">Roles Count</th>
                            <th width="20%">Created</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $permission->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="permission-icon me-2">
                                            <i class="material-icons-outlined text-success">security</i>
                                        </div>
                                        <div>
                                            <span class="badge bg-success fs-6">{{ $permission->name }}</span>
                                            <br>
                                            <small class="text-muted">{{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $permission->guard_name }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info fs-6 me-2">{{ $permission->roles_count ?? 0 }}</span>
                                        <small class="text-muted">roles</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $permission->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ $permission->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <!-- <a href="{{ route('permissions.show', $permission) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="View Details">
                                            <i class="material-icons-outlined">visibility</i>
                                        </a> -->
                                        <a href="{{ route('permissions.edit', $permission) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit Permission">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                        @if($permission->roles_count == 0)
                                            <form action="{{ route('permissions.destroy', $permission) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this permission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete Permission">
                                                    <i class="material-icons-outlined">delete</i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    disabled 
                                                    title="Cannot delete - assigned to roles">
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
                                        <i class="material-icons-outlined fs-1 mb-3">security</i>
                                        <h6>No permissions found</h6>
                                        <p class="mb-0">Create your first permission to get started</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($permissions->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-white">
                        Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} 
                        of {{ $permissions->total() }} permissions$permissions
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination round-pagination">
                            <li class="page-item {{ ($permissions->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $permissions->previousPageUrl() }}">Previous</a>
                            </li>
                            @for($i = 1; $i <= $permissions->lastPage(); $i++)
                                <li class="page-item {{ ($permissions->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $permissions->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ ($permissions->currentPage() == $permissions->lastPage()) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $permissions->nextPageUrl() }}">Next</a>
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
.permission-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(25, 135, 84, 0.1);
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
