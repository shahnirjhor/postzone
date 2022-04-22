@extends('layouts.layout')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('Change Password')</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block"></div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="m-b-0 text-white">@lang('Change Password')</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="form-group m-t-40 row @error('current-password') has-danger @enderror">
                            <label for="current-password" class="col-2 col-form-label">@lang('Current Password') <b class="ambitious-crimson">*</b></label>
                            <div class="col-10">
                                <input id="current-password" class="form-control" name="current-password" type="text" value="{{ old('current-password') }}" placeholder="@lang('Type Your Current Password Here')" required>
                                @error('current-password')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('new-password') has-danger @enderror">
                            <label for="new-password" class="col-2 col-form-label">@lang('New Password') <b class="ambitious-crimson">*</b></label>
                            <div class="col-10">
                                <input id="new-password" class="form-control" name="new-password" type="text" value="{{ old('new-password') }}" placeholder="@lang('Type Your New Password here')" required>
                                <small id="name" class="form-text text-muted">@lang('6 Characters Long')</small>
                                @error('new-password')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('new-password_confirmation') has-danger @enderror">
                            <label for="new-password_confirmation" class="col-2 col-form-label">@lang('Confirm Password') <b class="ambitious-crimson">*</b></label>
                            <div class="col-10">
                                <input id="new-password_confirmation" class="form-control" name="new-password_confirmation" type="text" value="{{ old('new-password_confirmation') }}" placeholder="@lang('Type Your Confirm Password Here')" required>
                                <small id="name" class="form-text text-muted">@lang('6 Characters Long')</small>
                                @error('new-password_confirmation')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
