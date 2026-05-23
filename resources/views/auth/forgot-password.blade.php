<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Forgot Password</title>
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
    .bg-forgot-password {
      background-image: url("{{ asset('dashboard/assets/images/auth/forgot-password1.png') }}") !important;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>

  </head>

  <body class="bg-forgot-password">

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
                  <h4 class="fw-bold">Forgot Password?</h4>
                  <p class="mb-0">Enter your registered email ID to reset the password</p>

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

                  <div class="form-body mt-4">
                    <form class="row g-4" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="col-12">
                            <label for="email" class="form-label">Email ID</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="example@user.com" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-grd-primary">Send Password Reset Link</button>
                                <a href="{{ route('login') }}" class="btn btn-light">Back to Login</a>
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

  </body>
</html>
