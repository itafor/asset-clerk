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
    <title>Sign Up | Asset Clerk</title>

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
    <style>
        .dt-login__bg-section:before {
            background-color: #87CEEB !important;
        }
    </style>
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
                    <h1 class="dt-login__title">Welcome to<br> <span style="font-size:30px"><b>Asset Clerk</b></span>
                    </h1>

                    <p class="f-16">Sign up to gain access to our amazing features.</p>

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
                    <h2 class="dt-login__title text-black-50">Sign Up</h2>
                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" autocomplete="false">
                    @csrf
                    <!-- Form Group -->
                        <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="firstname-1">First Name</label>
                            <input type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                   name="firstname" value="{{ old('firstname') }}" required id="firstname-1"
                                   aria-describedby="firstname-1" placeholder="Enter First Name">
                            @if ($errors->has('firstname'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->
                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="lastname-1">Last Name</label>
                            <input type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                   name="lastname" value="{{ old('lastname') }}" required id="lastname-1"
                                   aria-describedby="lastname-1" placeholder="Enter Last Name">
                            @if ($errors->has('lastname'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->
                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="lastname-1">Last Name</label>
                            <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   name="phone" value="{{ old('phone') }}" required id="phone-1"
                                   aria-describedby="phone-1" placeholder="Phone Number">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="email-1">Email Address</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required id="email-1"
                                   aria-describedby="email-1" placeholder="Enter Email Address">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="password-1">Password</label>
                            <input type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required id="password-1" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="password-1">Confirm Password</label>
                            <input type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password_confirmation" required placeholder="Confirm Password">
                        </div>
                        <!-- /form group -->

                         <!-- Form Group captcha -->
                        <div class="form-group{{ $errors->has('captcha') ? ' has-danger' : '' }}">
                            <label class="sr-only" for="captcha">Captcha</label>
                            <div class="captcha">
                                <span>{!!  Captcha::img() !!}</span>
                                <button type="button" class="btn btn-success btn-refresh">Refresh</button>
                            </div>
                          <input type="text" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                   name="captcha" id="captcha" placeholder="Type the above word " autocomplete="off">
                                    @if ($errors->has('captcha'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                    {{-- <div class="custom-control custom-checkbox mb-6 mb-lg-8">
                        <input class="custom-control-input" name="pri" type="checkbox" id="checkbox-1">
                        <label class="custom-control-label" for="checkbox-1">Remember Me</label>
                    </div> --}}
                    <!-- /form group -->

                        <!-- Form Group -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary text-uppercase">Create Account</button>
                            <span class="d-inline-block ml-4">Or
                            <a class="d-inline-block font-weight-medium ml-3" href="{{ route('login') }}">Sign In</a>
                            </span>
                        </div>
                        <!-- /form group -->

                        <!-- Form Group -->
                        <div class="d-flex flex-wrap align-items-center mb-3 mb-md-4">
                            <span class="d-inline-block mr-2">Or sign in with</span>

                            <!-- List -->
                            <ul class="dt-list dt-list-sm dt-list-cm-0 ml-auto">
                                <li class="dt-list__item">
                                    <!-- Fab Button -->
                                    <a href="{{url('login/facebook')}}"
                                       class="btn btn-outline-primary dt-fab-btn size-30">
                                        <i class="icon icon-facebook icon-xl"></i>
                                    </a>
                                    <!-- /fab button -->
                                </li>

                                <li class="dt-list__item">
                                    <!-- Fab Button -->
                                    <a href="{{ url('/login/google') }}"
                                       class="btn btn-outline-primary dt-fab-btn size-30">
                                        <i class="icon icon-google-plus icon-xl"></i>
                                    </a>
                                    <!-- /fab button -->
                                </li>

                                {{-- <li class="dt-list__item">
                                    <!-- Fab Button -->
                                    <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                        <i class="icon icon-github icon-xl"></i>
                                    </a>
                                    <!-- /fab button -->
                                </li>

                                <li class="dt-list__item">
                                    <!-- Fab Button -->
                                    <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                        <i class="icon icon-twitter icon-xl"></i>
                                    </a>
                                    <!-- /fab button -->
                                </li> --}}
                            </ul>
                            <!-- /list -->
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

<script>
    $('.btn-refresh').click(function(){
        $('#captcha').val('');
       $.ajax({
            url:"{{URL::to('refresh-captcha')}}",
            type: "GET",
            success: function(data){
                console.log(data.captcha)
                $('.captcha span').html(data.captcha);
            }
        })
    })
</script>
</body>
</html>