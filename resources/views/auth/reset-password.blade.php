<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Reset Password</title>
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
    .bg-reset-password {
      background-image: url("{{ asset('dashboard/assets/images/auth/reset-password1.png') }}") !important;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>

  </head>

  <body class="bg-reset-password">

    <!--authentication-->
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
     <div class="container my-5 my-lg-0">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                  <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" class="mb-4" width="145" alt="Crown Iconics">
                  </div>
                  <h4 class="fw-bold">Generate New Password</h4>
                  <p class="mb-0">We received your reset password request. Please enter your new password!</p>

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

                  <div class="form-body mt-4">
                    <form class="row g-4" method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $request->email) }}" 
                                   placeholder="Enter your email" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Enter new password" required>
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
                                       placeholder="Confirm password" required>
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-grd-info">Change Password</button>
                                <a href="{{ route('login') }}" class="btn btn-grd-royal">Back to Login</a>
                            </div>
                        </div>
                    </form>
                </div>

              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
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
  
  </body>
</html>
