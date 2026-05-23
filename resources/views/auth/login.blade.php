<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Login</title>
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
    .bg-login {
      background-image: url("{{ asset('dashboard/assets/images/auth/login1.png') }}") !important;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>

  </head>

  <body class="bg-login">
    <!--authentication-->
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
      <div class="container-fluid my-5 my-lg-0">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                  
                  <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" class="mb-4" width="145" alt="Crown Iconics">
                  </div>
                  
                  <!-- <h4 class="fw-bold">Get Started Now</h4> -->
                  <!-- <p class="mb-0">Enter your credentials to login your account</p> -->

                  @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

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

                  <div class="form-body my-5">
                    <form class="row g-3" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="jhon@example.com" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <div class="col-md-6">
                            <!-- <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div> -->
                        </div>
                        <div class="col-md-6 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot Password ?</a>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-grd-primary">Login</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-start">
                                <p class="mb-0">Don't have an account yet? <a href="{{ route('register') }}">Sign up here</a></p>
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
      });
    </script>
  
  </body>
</html>
