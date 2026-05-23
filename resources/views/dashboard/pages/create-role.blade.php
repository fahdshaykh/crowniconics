@extends('dashboard.layouts.app')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

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
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($role) ? 'Edit' : 'Create' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">{{ isset($role) ? 'Edit Role' : 'Create New Role' }}</h5>
                    <p class="mb-0 text-secondary">{{ isset($role) ? 'Update role information and permissions' : 'Create a new role with specific permissions' }}</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left text-primary"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Back to Roles
                    </a>
                </div>
            </div>
        </div>
    </div>

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

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}" method="POST">
                @csrf
                @if(isset($role))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $role->name ?? '') }}" 
                                   placeholder="Enter role name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Permissions <span class="text-danger">*</span></label>
                    <div class="row">
                        @if($permissions->count() > 0)
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input @error('permissions') is-invalid @enderror" 
                                               type="checkbox" name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="permission_{{ $permission->id }}"
                                               {{ isset($role) && $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="material-icons-outlined">info</i>
                                    No permissions available. Please create permissions first.
                                    <a href="{{ route('permissions.create') }}" class="alert-link">Add Permission</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @error('permissions')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="material-icons-outlined">save</i>
                        {{ isset($role) ? 'Update Role' : 'Create Role' }}
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4">
                        <i class="material-icons-outlined">cancel</i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
  </div>
</main>
<!--end main wrapper-->
@endsection
