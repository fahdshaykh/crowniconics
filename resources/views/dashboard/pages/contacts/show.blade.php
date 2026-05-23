@extends('dashboard.layouts.app')
@section('title', 'Contact Details')
@section('content')
<main class="main-wrapper">
<div class="main-content">
      <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Contact</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <!-- <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li> -->
                        <li class="breadcrumb-item active" aria-current="page">Contact Query Details</li>
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
                    <h5 class="mb-0 fw-bold">Contact us</h5>
                  </div>
                 </div>

                <!-- <form class="row g-4" method="POST" action="{{ route('contacts.update', $contact->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') -->

                    <div class="col-md-12">
                        <label for="first_name" class="form-label">First Name</label>
                        <input disabled type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" 
                               value="{{ old('first_name', $contact->first_name ?? '') }}" 
                               placeholder="First Name" readonly>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input disabled type="text" class="form-control @error('last_name') is-invalid @enderror"  readonly
                               id="last_name" name="last_name" 
                               value="{{ old('last_name', $contact->last_name ?? '') }}" 
                               placeholder="Last Name" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="phone" class="form-label">Phone</label>
                        <input disabled type="text" class="form-control @error('phone') is-invalid @enderror" readonly
                               id="phone" name="phone" 
                               value="{{ old('phone', $contact->phone ?? '') }}" 
                               placeholder="Phone">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input disabled type="email" class="form-control @error('email') is-invalid @enderror" readonly
                               id="email" name="email" 
                               value="{{ old('email', $contact->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="subject" class="form-label">Inquiry Type</label>
                        <select disabled id="subject" name="subject" class="form-select @error('subject') is-invalid @enderror" required readonly>
                            <option value="">Choose...</option>
                            <option value="General Inquiry" {{ old('subject', isset($contact) ? $contact->subject ?? '' : '') == 'General Inquiry' ? 'selected' : '' }}>
                                General Inquiry
                            </option>
                            <option value="Support" {{ old('subject', isset($contact) ? $contact->subject ?? '' : '') == 'Support' ? 'selected' : '' }}>
                                Support
                            </option>
                            <option value="Partnership" {{ old('subject', isset($contact) ? $contact->subject ?? '' : '') == 'Partnership' ? 'selected' : '' }}>
                                Partnership
                            </option>
                            <option value="Other" {{ old('subject', isset($contact) ? $contact->subject ?? '' : '') == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>
                        </select>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-12">
                        <label for="message" class="form-label">message</label>
                        <textarea disabled class="form-control @error('message') is-invalid @enderror" readonly
                                  id="message" name="message" 
                                  placeholder="message ..." rows="4" cols="4">{{ old('message', $contact->message ?? '') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4">
                                {{ isset($contact) ? 'Update User' : 'Create User' }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-light px-4">Cancel</a>
                        </div>
                    </div> -->
                <!-- </form> -->
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
        let initialStateId = "{{ old('state_id', $contact->state_id ?? '') }}";
        let initialCityId = "{{ old('city_id', $contact->city_id ?? '') }}";

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
        @if(isset($contact) && $contact->country_id || old('country_id'))
            countrySelect.value = "{{ old('country_id', $contact->country_id ?? '') }}";
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