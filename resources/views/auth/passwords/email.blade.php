<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <title>@lang('Reset Password Title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('plugins/custom/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('plugins/custom/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('plugins/custom/css/colors/default.css') }}" id="theme"  rel="stylesheet">
    <!-- Ambitious CSS -->
    <link href="{{ asset('plugins/custom/css/ambitious.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('plugins/custom/js/html5shiv.js') }}"></script>
    <script src="{{ asset('plugins/custom/js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box login-sidebar">
        <div class="white-box">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
             @endif
             <form method="POST" class="form-horizontal form-material" action="{{ route('password.email') }}">
                @csrf
                <a href="#" class="text-center db"><img style="max-width : 100px; height :auto" src="{{ asset('img/favicon.png') }}" alt="Home" /><br/><img style="max-width : 140px; height : 24px; margin-top : 8px" src="{{ asset('img/logo-text.png') }}" alt="Home" /></a>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="@lang('Email')">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                            @lang('Send Password Reset Link')
                        </button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p>@lang('Go Back To') <a href="/login" class="text-info"><b>@lang('Login')</b></a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--slimscroll JavaScript -->
<script src="{{ asset('plugins/custom/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('plugins/custom/js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('plugins/custom/js/custom.js') }}"></script>
</body>
</html>

