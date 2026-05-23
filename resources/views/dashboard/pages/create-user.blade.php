@extends('dashboard.layouts.app')
@if(isset($user))
    @section('title', 'Edit User') 
@else
    @section('title', 'Create User') 

@endif
@section('content')
<main class="main-wrapper">
<div class="main-content">
      <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <!-- <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li> -->
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($user) ? 'Edit User' : 'Create User' }}</li>
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

        <div class="row " >
            <div class="col-1 col-xl-1">
            </div>
           <div class="col-10 col-xl-10">
            <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">{{ isset($user) ? 'Edit User' : 'Create User' }}</h5>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class="material-icons-outlined fs-5">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('users') }}">Back to Users</a></li>
                      <li><a class="dropdown-item" href="{{ route('user.create') }}">Create New User</a></li>
                    </ul>
                  </div>
                 </div>

                <form class="row g-4" method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" 
                               value="{{ old('first_name', $user->first_name ?? '') }}" 
                               placeholder="First Name" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" 
                               value="{{ old('last_name', $user->last_name ?? '') }}" 
                               placeholder="Last Name" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" 
                               value="{{ old('phone', $user->phone ?? '') }}" 
                               placeholder="Phone">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" 
                               value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Password {{ isset($user) ? '(leave blank to keep current)' : '' }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               {{ isset($user) ? '' : 'required' }}>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(!isset($user))
                    <div class="col-md-12">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>
                    @endif

                    <div class="col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Choose...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" 
                                    {{ old('role', isset($user) ? $user->roles->first()->name ?? '' : '') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">Choose...</option>
                            <option value="active" {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('status', $user->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="country" class="form-label">Country</label>
                        <select id="country" name="country" class="form-select @error('country') is-invalid @enderror">
                            <option value="">Choose...</option>

                            @foreach($countries as $country)
                            <option value="{{$country->id}}" {{ old('country', $user->country ?? '') == $country->name ? 'selected' : '' }}>
                                {{ $country->name}} 
                            </option>
                            @endforeach

                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                               id="city" name="city" 
                               value="{{ old('city', $user->city ?? '') }}" 
                               placeholder="City">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>
                        <select id="state" name="state" class="form-select @error('state') is-invalid @enderror">
                           
                        </select>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="zip_code" class="form-label">Zip</label>
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                               id="zip_code" name="zip_code" 
                               value="{{ old('zip_code', $user->zip_code ?? '') }}" 
                               placeholder="Zip">
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" 
                                  placeholder="Address ..." rows="4" cols="4">{{ old('address', $user->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input class="form-control @error('profile_image') is-invalid @enderror" 
                               type="file" id="profile_image" name="profile_image" 
                               accept="image/*">
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(isset($user) && $user->profile_image)
                            <div class="mt-2">
                                <small class="text-muted">Current image:</small>
                                <img src="{{ $user->profile_image_url }}" alt="Profile" class="ms-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4">
                                {{ isset($user) ? 'Update User' : 'Create User' }}
                            </button>
                            <a href="{{ route('users') }}" class="btn btn-light px-4">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
            </div>
           </div>  
            <div class="col-1 col-xl-1">
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = $(this).val();

            if (countryId) {
                $.ajax({
                    url: "/admin/users/get-states/" + countryId, 
                    type: "GET",
                    success: function (data) {
                        $('#state').empty().append('<option value="">Select State</option>');
                        $.each(data, function (key, state) {
                            $('#state').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });

                        // Auto-select user’s state if exists
                        @if(isset($user) && $user->state_id)
                            $('#state').val("{{ $user->state_id }}");
                        @endif
                    }
                });
            } else {
                $('#state_id').empty().append('<option value="">Select State</option>');
            }
        });

        $('#country').on('change', function () {
            var countryId = $(this).val();

            if (countryId) {
                $.ajax({
                    url: "/admin/users/get-states/" + countryId, 
                    type: "GET",
                    success: function (data) {
                        $('#state').empty().append('<option value="">Select State</option>');
                        $.each(data, function (key, state) {
                            $('#state').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });

                        // Auto-select user’s state if exists
                        @if(isset($user) && $user->state_id)
                            $('#state').val("{{ $user->state_id }}");
                        @endif
                    }
                });
            } else {
                $('#state_id').empty().append('<option value="">Select State</option>');
            }
        });

        // Trigger change if country already selected (for edit form)
        @if(isset($user) && $user->country_id)
            $('#country_id').trigger('change');
        @endif
    });
</script>


<!--end main wrapper-->
@endsection