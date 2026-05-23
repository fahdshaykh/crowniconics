@extends('dashboard.layouts.app')

@section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

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
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($permission) ? 'Edit' : 'Create' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">{{ isset($permission) ? 'Edit Permission' : 'Create New Permission' }}</h5>
                    <p class="mb-0 text-secondary">{{ isset($permission) ? 'Update permission information' : 'Create a new system permission' }}</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary px-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left text-primary"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>    
                    Back to Permissions
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
            <form action="{{ isset($permission) ? route('permissions.update', $permission) : route('permissions.store') }}" method="POST">
                @csrf
                @if(isset($permission))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $permission->name ?? '') }}" 
                                   placeholder="e.g., user.create, user.edit, user.delete" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Use lowercase with dots or underscores (e.g., user.create, user_edit)</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name</label>
                            <select class="form-select @error('guard_name') is-invalid @enderror" 
                                    id="guard_name" name="guard_name">
                                <option value="web" {{ (old('guard_name', $permission->guard_name ?? 'web') == 'web') ? 'selected' : '' }}>Web</option>
                                <option value="api" {{ (old('guard_name', $permission->guard_name ?? 'web') == 'api') ? 'selected' : '' }}>API</option>
                            </select>
                            @error('guard_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">The authentication guard this permission applies to</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="material-icons-outlined">save</i>
                        {{ isset($permission) ? 'Update Permission' : 'Create Permission' }}
                    </button>

                 
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary px-4">
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
