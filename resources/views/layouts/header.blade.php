<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html">
                <b>
                    <img id="custom-sidebar-logo" src="{{ asset('img/logo-text.png') }}" alt="homepage" class="dark-logo" />
                </b>
                <span id="logo-text-color">
                    @php
                        $strIn = $ApplicationSetting->item_short_name;
                        $arrayIn = explode(" ",$strIn);
                    @endphp
                    <strong><b>{{ $arrayIn[0] }}</b>@if (!empty($arrayIn[1])) {{$arrayIn[1]}}@endif</strong>
                </span>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="sl-icon-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="sl-icon-menu"></i></a> </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    @php
                        $locale = App::getLocale();
                    @endphp

                    @foreach ($getLang as $key => $value)
                        @if($locale == $key)
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon {{ $flag[$key] }}"></i></a>
                        @endif
                    @endforeach
                    <div class="dropdown-menu dropdown-menu-right animated bounceInDown">
                        @foreach ($getLang as $key => $value)
                            <a class="dropdown-item" href="{{ route('lang.index', ['language' => $key]) }}" @if ($key == $locale) @endif><span class="flag-icon {{ $flag[$key] }}"> </span>  {{ $value }}</a>
                        @endforeach
                    </div>
                </li>
                <?php
                    if(Auth::user()->photo == NULL)
                    {
                        $photo = "img/profile/male.png";
                    } else {
                        $photo = Auth::user()->photo;
                    }
                ?>
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset($photo) }}" alt="user" class="" />
                        <span class="hidden-md-down">{{ Auth::user()->name }} &nbsp;<i class="fa fa-angle-down"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ asset($photo) }}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                        <a href="{{ route('profile.view') }}" class="btn btn-rounded btn-danger btn-sm">@lang('View Profile')</a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('profile.view') }}"><i class="ti-user"></i> @lang('My Profile')</a></li>
                            <li><a href="{{ route('profile.setting') }}"><i class="ti-settings"></i> @lang('Account Setting')</a></li>
                            <li><a href="{{ route('profile.password') }}"><i class="fa fa-key"></i> @lang('Change Password')</a></li>
                            <li role="separator" class="divider"></li>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off mr-2"></i> @lang('Logout')</a>
                            <form id="logout-form" class="ambitious-display-none" action="{{ route('logout') }}" method="POST">@csrf</form>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
