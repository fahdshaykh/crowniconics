@extends('dashboard.layouts.app')
@section('title', isset($user->id) ? 'Edit User' : 'Create User')
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
                      <li><a class="dropdown-item" href="{{ route('users.index') }}">Back to Users</a></li>
                      <li><a class="dropdown-item" href="{{ route('user.create') }}">Create New User</a></li>
                    </ul>
                  </div>
                 </div>

                <form class="row g-4" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                        <label for="country_id" class="form-label">Country</label>
                        <select name="country_id" id="country_id"
                            class="form-select @error('country_id') is-invalid @enderror" required>
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $user->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                    {{ ucfirst($country->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="state_id" class="form-label">State</label>
                        <select name="state_id" id="state_id"
                            class="form-select @error('state_id') is-invalid @enderror" required>
                            <option value="">Select State</option>
                        </select>
                        @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="city_id" class="form-label">City</label>
                        <select name="city_id" id="city_id"
                            class="form-select @error('city_id') is-invalid @enderror" required>
                            <option value="">Select City</option>
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="zip_code" class="form-label">Zip</label>
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                               id="zip_code" name="zip_code" 
                               value="{{ old('zip_code', $user->zip_code ?? '') }}" 
                               placeholder="Zip">
                        @error('zip_code')
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

                    <!-- modules for professionals -->

                    <div id="professional-fields" style="display: none;">
                        
                        <div class="col-md-12">
                            <label for="service_id" class="form-label">Service</label>
                            <select name="service_id" id="service_id"
                                class="form-select @error('service_id') is-invalid @enderror" required>
                                <option value="">Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ old('service_id', $user->services->first()->pivot->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                        {{ ucfirst($service->title) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ old('price', optional($user->services->first())->pivot->price ?? '') }}"
                                    placeholder="Enter Years">
                            </div>

                            <div class="col-md-6">
                                <label for="experience_years" class="form-label">Experience (Years)</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years"
                                    value="{{ old('experience_years', $user->services->first()->pivot->experience_years ?? '') }}" placeholder="Enter Years">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="personal_information" class="form-label">Personal Information</label>
                            <textarea class="form-control @error('personal_information') is-invalid @enderror" 
                                    id="personal_information" name="personal_information" 
                                    placeholder="Personal information ..." rows="4" cols="4">{{ old('personal_information', $user->services->first()->pivot->personal_information ?? '') }}</textarea>
                            @error('personal_information')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <!-- professionals modules end here  -->

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
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">
                                Save
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-light px-4">Cancel</a>
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
    document.addEventListener("DOMContentLoaded", function () {
        let countrySelect = document.getElementById('country_id');
        let stateSelect = document.getElementById('state_id');
        let citySelect = document.getElementById('city_id');
        let initialStateId = "{{ old('state_id', $user->state_id ?? '') }}";
        let initialCityId = "{{ old('city_id', $user->city_id ?? '') }}";

        // Country change event
        countrySelect.addEventListener('change', function() {
            let countryId = this.value;
            stateSelect.innerHTML = '<option value="">Select State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (countryId) {
                fetch(`/get-states/${countryId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(state => {
                            let option = new Option(state.name, state.id);
                            stateSelect.add(option);
                        });
                        // Pre-select state if initial value exists
                        if (initialStateId && countrySelect.value) {
                            stateSelect.value = initialStateId;
                            initialStateId = null; // Clear after first use
                            stateSelect.dispatchEvent(new Event('change')); // Trigger state change
                        }
                    });
            }
        });

        // State change event
        stateSelect.addEventListener('change', function() {
            let stateId = this.value;
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (stateId) {
                fetch(`/get-cities/${stateId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(city => {
                            let option = new Option(city.name, city.id);
                            citySelect.add(option);
                        });
                        // Pre-select city if initial value exists
                        if (initialCityId && stateSelect.value) {
                            citySelect.value = initialCityId;
                            initialCityId = null; // Clear after first use
                        }
                    });
            }
        });

        // Trigger change if country is pre-selected (for edit or validation fail)
        @if(isset($user) && $user->country_id || old('country_id'))
            countrySelect.value = "{{ old('country_id', $user->country_id ?? '') }}";
            countrySelect.dispatchEvent(new Event('change'));
        @endif
    });

    // Role-based professional fields toggle (unchanged)
    document.addEventListener("DOMContentLoaded", function () {
        let roleSelect = document.getElementById("role");
        let professionalFields = document.getElementById("professional-fields");

        function toggleProfessionalFields() {
            if (roleSelect.value === "professional") {
                professionalFields.style.display = "block";
            } else {
                professionalFields.style.display = "none";
            }
        }

        roleSelect.addEventListener("change", toggleProfessionalFields);
        toggleProfessionalFields(); // Run on page load
    });
</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        let roleSelect = document.getElementById("role");
        let professionalFields = document.getElementById("professional-fields");

        function toggleProfessionalFields() {
            if (roleSelect.value === "professional") {
                professionalFields.style.display = "block";
            } else {
                professionalFields.style.display = "none";
            }
        }

        roleSelect.addEventListener("change", toggleProfessionalFields);

        // Run on page load (for edit user)
        toggleProfessionalFields();
    });

</script>


<!--end main wrapper-->
@endsection