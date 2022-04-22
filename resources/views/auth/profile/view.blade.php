@extends('layouts.layout')
@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="white-box">
            <div class="user-bg"> <img width="100%" alt="user" src="{{ asset('img/logo-background.png') }}">
                <div class="overlay-box">
                    <div class="user-content">
                        @php
                        if($user->photo == null) {
                            $photo = "img/profile/male.png";
                        } else {
                            $photo = $user->photo;
                        }
                        @endphp
                        <a href="#"><img src="{{ asset($photo) }}" class="thumb-lg img-circle" alt="img"></a>
                        <h4 class="text-white">{{  strtok(Auth::user()->name, " ") }}</h4>
                        <h5 class="text-white">{{ $user->email }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="white-box">
            <ul class="nav nav-tabs tabs customtab">
                <li class="tab active">
                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">@lang('Profile')</span> </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    <div class="row">
                        <div class="col-md-3 col-xs-6 b-r"> <strong>@lang('Full Name')</strong>
                            <br>
                            <p class="text-muted">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>@lang('Mobile')</strong>
                            <br>
                            <p class="text-muted">{{ $user->phone }}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>@lang('Email')</strong>
                            <br>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-3 col-xs-6"> <strong>@lang('Address')</strong>
                            <br>
                            <p class="text-muted">{!! $user->address !!}</p>
                        </div>
                    </div>
                    <hr>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
