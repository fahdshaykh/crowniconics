<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Register</title>
  <!--favicon-->
	<link rel="icon" href="{{ asset('assets/icon/favicon.png') }}" type="image/png">
  <!-- loader-->
	<link href="{{ asset('dashboard/assets/css/pace.min.css') }}" rel="stylesheet">
	<script src="{{ asset('dashboard/assets/js/pace.min.js') }}"></script>

  <!--plugins-->
  <link href="{{ asset('dashboard/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/assets/plugins/metismenu/metisMenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/assets/plugins/metismenu/mm-vertical.css') }}">
  <!--bootstrap css-->
  <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('dashboard/sass/main.css') }}" rel="stylesheet">
  <link href="{{ asset('dashboard/sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('dashboard/sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('dashboard/sass/responsive.css') }}" rel="stylesheet">

  <style>
    /* Fix background image paths */
    .bg-register {
      background-image: url("{{ asset('dashboard/assets/images/auth/register1.png') }}") !important;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>

  </head>

  <body class="bg-register">

    <!--authentication-->
    <div class="container-fluid my-5">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-5 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                  <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" class="mb-4" width="145" alt="Crown Iconics">
                  </div>
                  <h4 class="fw-bold">Get Started Now</h4>
                  <p class="mb-0">Enter your credentials to create your account</p>

                  @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                  <div class="form-body my-4">
                    <form class="row g-3" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="col-12">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                   placeholder="John" required autofocus>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                   placeholder="Doe" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="example@user.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   placeholder="+1234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
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

                        <div class="col-12">
                          <label for="role" class="form-label">I want to:</label>
                          <div class="row">
                              <div class="col-4">
                                  <div class="form-check">
                                      <input class="form-check-input @error('role') is-invalid @enderror" 
                                              type="radio" name="role" id="buy" value="customer" 
                                              {{ old('role') == 'customer' ? 'checked' : '' }} required>
                                      <label class="form-check-label" for="buy">
                                          <i class="bi bi-cart-plus text-success"></i> Buy
                                      </label>
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="form-check">
                                      <input class="form-check-input @error('role') is-invalid @enderror" 
                                              type="radio" name="role" id="sell" value="agent" 
                                              {{ old('role') == 'agent' ? 'checked' : '' }} required>
                                      <label class="form-check-label" for="sell">
                                          <i class="bi bi-tag text-warning"></i> Sell
                                      </label>
                                  </div>
                              </div>
                              <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('role') is-invalid @enderror" 
                                          type="radio" name="role" id="professional" value="professional" 
                                          {{ old('role') == 'professional' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="professional">
                                        <i class="bi bi-briefcase text-primary"></i> Professional
                                    </label>
                                </div>
                              </div>
                          </div>
                          @error('user_type')
                              <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>

                        <!-- Services dropdown -->
                        <!-- <div class="col-12 mt-3" id="servicesDropdown" style="display: none;">
                            <label for="services" class="form-label">Select Service:</label>
                            <select class="form-select @error('services') is-invalid @enderror" name="services" id="services">
                                  <option value=""> Choose a Service </option>    
                                  @foreach($services as $service)
                                  <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                      {{ $service->title }}
                                  </option>
                                @endforeach
                            </select>
                            @error('services')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div> -->
                        
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Enter Password" required>
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group" id="show_hide_password_confirm">
                                <input type="password" class="form-control border-end-0" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirm Password" required>
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('terms') is-invalid @enderror" 
                                       type="checkbox" id="terms" name="terms" 
                                       {{ old('terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="terms">
                                    I read and agree to <a href="#" target="_blank">Terms & Conditions</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-grd-danger">Register</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-start">
                                <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                            </div>
                        </div>
                    </form>
                </div>

                  <!-- <div class="separator section-padding">
                    <div class="line"></div>
                    <p class="mb-0 fw-bold">OR</p>
                    <div class="line"></div>
                  </div>

                  <div class="d-flex gap-3 justify-content-center mt-4">
                    <a href="javascript:;" class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-grd-danger">
                      <i class="bi bi-google fs-5 text-white"></i>
                    </a>
                    <a href="javascript:;" class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-grd-deep-blue">
                      <i class="bi bi-facebook fs-5 text-white"></i>
                    </a>
                    <a href="javascript:;" class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-grd-info">
                      <i class="bi bi-linkedin fs-5 text-white"></i>
                    </a>
                    <a href="javascript:;" class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-grd-royal">
                      <i class="bi bi-github fs-5 text-white"></i>
                    </a>
                  </div> -->

              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
      
    <!--authentication-->

    <!--plugins-->
    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>

    <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });

        $("#show_hide_password_confirm a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password_confirm input').attr("type") == "text") {
            $('#show_hide_password_confirm input').attr('type', 'password');
            $('#show_hide_password_confirm i').addClass("bi-eye-slash-fill");
            $('#show_hide_password_confirm i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password_confirm input').attr("type") == "password") {
            $('#show_hide_password_confirm input').attr('type', 'text');
            $('#show_hide_password_confirm i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password_confirm i').addClass("bi-eye-fill");
          }
        });
      });
    </script>

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
</script>

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    const professionalRadio = document.getElementById("professional");
    const servicesDropdown = document.getElementById("servicesDropdown");
    const radios = document.querySelectorAll('input[name="role"]');

    function toggleServices() {
        if (professionalRadio.checked) {
            servicesDropdown.style.display = "block";
        } else {
            servicesDropdown.style.display = "none";
        }
    }

    // Run on page load (so old('role') works)
    toggleServices();

    // Listen for radio changes
    radios.forEach(radio => {
        radio.addEventListener("change", toggleServices);
    });
});
</script> -->
  
  </body>
</html>
