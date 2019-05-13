<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Asset Clerk">
    <meta name="keywords" content="Asset Clerk">
    <!-- /meta tags -->
    <title>Reset Password | Asset Clerk</title>

    <!-- Site favicon -->
    <link href="{{url('img/logo.png')}}" rel="icon" type="image/png">
    <!-- /site favicon -->

    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="{{url('assets/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/gaxon-icon/style.css')}}">
    <!-- /font icon Styles -->

    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="{{url('assets/perfect-scrollbar/css/perfect-scrollbar.css')}}">
    <!-- /perfect scrollbar stylesheet -->

    <!-- Load Styles -->

    <link rel="stylesheet" href="{{url('assets/css/lite-style-1.min.css')}}">
  <!-- /load styles -->
    <script>
        var baseUrl = '{{url("/")}}';
    </script>
</head>
<body class="dt-sidebar--fixed dt-header--fixed">

<!-- Loader -->
<div class="dt-loader-container">
    <div class="dt-loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
        </svg>
    </div>
</div>
<!-- /loader -->

<!-- Root -->
<div class="dt-root">

    <!-- Login Container -->
    <div class="dt-login--container dt-app-login--container">

        <!-- Login Content -->
        <div class="dt-login__content-wrapper">

            <!-- Login Background Section -->
            <div class="dt-login__bg-section" style="background-image: none !important">

                <div class="dt-login__bg-content">
                    <!-- Login Title -->
                    <h1 class="dt-login__title">Welcome to<br> <span style="font-size:30px"><b>Asset Clerk</b></span></h1>

                    {{-- <p class="f-16">Sign in to gain access to our amazing features.</p> --}}

                </div>


                <!-- Brand logo -->
                <div class="dt-login__logo">
                    <a class="dt-brand__logo-link" href="{{url('/')}}">
                        <img class="dt-brand__logo-img" src="{{url('img/logo.png')}}" alt="Wieldy">
                    </a>
                </div>
                <!-- /brand logo -->

            </div>
            <!-- /login background section -->

            <!-- Login Content Section -->
            <div class="dt-login__content">

                <!-- Login Content Inner -->
                <div class="dt-login__content-inner">
                    <h2 class="dt-login__title text-black-50">Reset Password</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Form -->
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="email-1">Email address</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required id="email-1" aria-describedby="email-1" placeholder="Enter email">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="password-1">Email address</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required id="password-1" aria-describedby="password-1" placeholder="Enter Password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->
                        <!-- /form group -->
                        <div class="form-group">
                            <label class="sr-only">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary text-uppercase">Reset Password</button>
                        </div>
                        <!-- /form group -->

                    </form>
                    <!-- /form -->

                </div>
                <!-- /login content inner -->

            </div>
            <!-- /login content section -->

        </div>
        <!-- /login content -->

    </div>
    <!-- /login container -->
  
</div>
<!-- /root -->

<!-- Optional JavaScript -->
<script src="{{url('assets/jquery/dist/jquery.min.js')}}"></script>
<script src="{{url('assets/moment/moment.js')}}"></script>
<script src="{{url('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Perfect Scrollbar jQuery -->
<script src="{{url('assets/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<!-- /perfect scrollbar jQuery -->

<!-- masonry script -->
<script src="{{url('assets/masonry-layout/dist/masonry.pkgd.min.js')}}"></script>
<script src="{{url('assets/sweetalert2/dist/sweetalert2.js')}}"></script>

<!-- Custom JavaScript -->
<script src="{{url('assets/js/script.js')}}"></script>

</body>
</html>