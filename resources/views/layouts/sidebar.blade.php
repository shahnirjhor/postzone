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
