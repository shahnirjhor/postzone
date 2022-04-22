@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="m-b-0 text-white">@lang('Account Setting Title')</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('profile.updateSetting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group m-t-40 row @error('name') has-danger @enderror">
                            <label for="name" class="col-2 col-form-label">@lang('Name') <b class="ambitious-crimson">*</b></label>
                            <div class="col-10">
                                <input id="name" class="form-control" name="name" type="text" value="{{ $user->name }}" placeholder="@lang('Type Your Name Here')" required>
                                @error('name')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('email') has-danger @enderror">
                            <label for="email" class="col-2 col-form-label">@lang('Email') <b class="ambitious-crimson">*</b></label>
                            <div class="col-10">
                                <input id="email" class="form-control" name="email" type="text" value="{{ $user->email }}" placeholder="@lang('Type Your Email Here')" required>
                                @error('email')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('phone') has-danger @enderror">
                            <label for="phone" class="col-2 col-form-label">@lang('Phone')</label>
                            <div class="col-10">
                                <input id="phone" class="form-control" name="phone" type="text" value="{{ $user->phone }}" placeholder="@lang('Type Your Phone Here')">
                                @error('phone')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('photo') has-danger @enderror">
                            <label for="phone" class="col-2 col-form-label">@lang('Photo')</label>
                            <div class="col-10">
                                <input id="photo" class="dropify" name="photo" value="{{ old('photo') }}" type="file" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2024K" />
                                <small id="name" class="form-text text-muted">@lang('Leave Blank For Remain Unchanged')</small>
                                <p>@lang('Max Size: 2mb, Allowed Format: png, jpg, jpeg')</p>
                                @error('photo')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-t-40 row @error('address') has-danger @enderror">
                            <label for="address" class="col-2 col-form-label">@lang('Address')</label>
                            <div class="col-10">
                                <div id="edit_input_address"></div>
                                <input type="hidden" name="address" id="address" value="{{ $user->address }}">
                                @error('address')
                                <small class="form-control-feedback">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="form-group m-b-0">
                            <div class="offset-sm-2 col-sm-9">
                                <button type="submit" id="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-inverse">@lang('Cancel')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    @include('script.setting.js')
@endsection
