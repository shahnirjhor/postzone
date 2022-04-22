@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="m-b-0 text-white">@lang('Edit SMTP')</h4>
            </div>
            <div class="card-body">
                <form id="userQuickForm" action="{{ route('smtp.update', $data) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-12">
                                <div class="form-group @error('email_address') has-danger @enderror">
                                    <label class="control-label">@lang('Email') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="email_address" value="{{ old('email_address',$data->email_address) }}" id="email_address" type="text" placeholder="@lang('Please Type Your SMTP Email')" required>
                                    @error('email_address')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('smtp_host') has-danger @enderror">
                                    <label class="control-label">@lang('Host') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="smtp_host" value="{{ old('smtp_host',$data->smtp_host) }}" id="smtp_host" type="text" placeholder="@lang('Please Type Your SMTP Host')" required>
                                    @error('smtp_host')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('smtp_port') has-danger @enderror">
                                    <label class="control-label">@lang('Port') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="smtp_port" value="{{ old('smtp_port',$data->smtp_port) }}" id="smtp_port" type="text" placeholder="@lang('Please Type Your SMTP Port')" required>
                                    @error('smtp_port')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('smtp_user') has-danger @enderror">
                                    <label class="control-label">@lang('User') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="smtp_user" value="{{ old('smtp_user',$data->smtp_user) }}" id="smtp_user" type="text" placeholder="@lang('Please Type Your Smtp User')" required>
                                    @error('smtp_user')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('smtp_password') has-danger @enderror">
                                    <label class="control-label">@lang('Password') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="smtp_password" value="{{ old('smtp_password',$data->smtp_password) }}" id="smtp_password" type="text" placeholder="@lang('Please Type Your SMTP Password')" required>
                                    @error('smtp_password')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('smtp_type') has-danger @enderror">
                                    <label class="control-label">@lang('Type')</label>
                                    <select id="smtp_type" class="form-control custom-select" name="smtp_type">
                                        <option value="default" {{ old('smtp_type', $data->smtp_type) == "default" ? 'selected' : '' }} >@lang('Default')</option>
                                        <option value="ssl" {{ old('smtp_type', $data->smtp_type) == "ssl" ? 'selected' : '' }} >@lang('SSL')</option>
                                        <option value="tls" {{ old('smtp_type', $data->smtp_type) == "tls" ? 'selected' : '' }} >@lang('Tls')</option>
                                    </select>
                                    @error('smtp_type')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('status') has-danger @enderror">
                                    <label class="control-label">@lang('Status')</label>
                                    <select id="status" class="form-control custom-select" name="status">
                                        <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }} >@lang('Active')</option>
                                        <option value="0" {{ old('status', $data->status) == 0 ? 'selected' : '' }} >@lang('Inactive')</option>
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
                        <a href="{{ route('smtp.index') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
