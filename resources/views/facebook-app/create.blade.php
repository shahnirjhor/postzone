@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12 m-t-30">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title m-b-0">@lang('Facebook URL')</h4>
            </div>
            <div class="card-body">
                <P>App Domain :  {{ Request::root() }}<br/>Site URL : {{ url('/') }}</P>
                <p>Privacy Policy URL : {{ url('/privacy-policy') }}<br/>Terms of Service URL : {{ url('/terms-of-service') }}</p>
                <p>Valid OAuth redirect URI :<br/>
                {{ url('/fb-login-callback') }}<br/>
                {{ url('/refresh-token-callback') }}
            </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">@lang('Create Facebook App')</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('facebook-apps.store') }}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('app_name') has-danger @enderror">
                                    <label class="control-label">@lang('App Name') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="app_name" value="{{ old('app_name') }}" id="app_name" type="text" placeholder="@lang('Type Your App Name Here')" required>
                                    @error('app_name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('api_id') has-danger @enderror">
                                    <label class="control-label">@lang('App Id') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="api_id" value="{{ old('api_id') }}" id="api_id" type="text" placeholder="@lang('Type Your Api Id Here')" required>
                                    @error('api_id')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('api_secret') has-danger @enderror">
                                    <label class="control-label">@lang('App Secret') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="api_secret" value="{{ old('api_secret') }}" id="api_secret" type="text" placeholder="@lang('Type Your App Secret Here')" required>
                                    @error('api_secret')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('status') has-danger @enderror">
                                    <label class="control-label">@lang('Status') <b class="ambitious-crimson">*</b></label>
                                    <select id="status" class="form-control custom-select" name="status">
                                        <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>@lang('Active')</option>
                                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>@lang('Inactive')</option>
                                    </select>
                                    @error('status')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="{{ route('facebook-apps.index') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
