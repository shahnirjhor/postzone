@php
$c = Request::segment(1);
$m = Request::segment(2);
$RoleName = Auth::user()->getRoleNames();
@endphp

<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false"><i
                    class="icon-Dashboard"></i><span class="hide-menu">@lang('Dashboard')</span></a>
                </li>

                <li @if($c == 'facebook-apps') class="active" @endif>
                    <a class="waves-effect waves-dark" href="{{ route('facebook-apps.index') }}" aria-expanded="false">
                        <i class="icon-Plug-In"></i><span class="hide-menu">@lang('Facebook App')</span>
                    </a>
                </li>

                <li @if($c == 'connect-account') class="active" @endif>
                    <a class="waves-effect waves-dark" href="{{ route('connect-account.index') }}" aria-expanded="false">
                        <i class="icon-Add"></i><span class="hide-menu">@lang('Connect Account')</span>
                    </a>
                </li>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i
                    class="icon-Press"></i><span class="hide-menu">@lang('Auto Post')</span></a>
                </li>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i
                    class="icon-Duplicate-Layer"></i><span class="hide-menu">@lang('Carousel Post')</span></a>
                </li>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i
                    class="icon-Phone-2"></i><span class="hide-menu">@lang('CTA Post')</span></a>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="nav-icon icon-Bar-Chart2"></i><span class="hide-menu">@lang('Report')</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">@lang('Auto Post Report')</a></li>
                        <li><a href="#">@lang('Carousel Post Report')</a></li>
                        <li><a href="#">@lang('CTA Post Report')</a></li>
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i
                    class="icon-Timer"></i><span class="hide-menu">@lang('Cron Job')</span></a>
                </li>


                <li @if($c == 'roles' || $c == 'users' || $c == 'apsetting' || $c == 'smtp') class="active" @endif>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="nav-icon fa fa-cogs"></i><span class="hide-menu">@lang('Settings')</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('roles.index') }}" @if($c == 'roles') class="active" @endif>@lang('Role Management')</a></li>
                        <li><a href="{{ route('users.index') }}" @if($c == 'users') class="active" @endif>@lang('User Management')</a></li>
                        <li><a href="{{ route('apsetting') }}" @if($c == 'apsetting') class="active" @endif>@lang('Application Settings')</a></li>
                        <li><a href="{{ route('smtp.index') }}" @if($c == 'smtp') class="active" @endif>@lang('Smtp Settings')</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
