<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
        <title>@lang('Log in') | eVoice :: ambitiousit.net</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('plugins/dist/css/adminlte.min.css') }}" />
        <link href="{{ asset('plugins/custom/css/frontend.css') }}" rel="stylesheet">
        @if(session('locale') == 'ar')
            <link href="{{ asset('plugins/custom/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
        @else
            <link href="{{ asset('plugins/alertifyjs/css/themes/bootstrap.min.css') }}" rel="stylesheet">
        @endif
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a class="h1"><span class="identColor"><b>e</b></span>Voice</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg m-0 p-0">@lang('Sign in to start your session')</p>
                    <br>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="@lang('Email')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="@lang('Password')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        @if(session('locale') == 'ar')
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-primary"> <i class="fas fa-sign-in-alt mr-2"></i> @lang('Log in')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        @if(session('locale') == 'ar')
            <script src="{{ asset('plugins/custom/js/bootstrap.bundle.min.js') }}"></script>
        @else
            <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
        @endif
        <script src="{{ asset('plugins/custom/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('plugins/custom/js/custom/login.js') }}"></script>
    </body>
</html>
