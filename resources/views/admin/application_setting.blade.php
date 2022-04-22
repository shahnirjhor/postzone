@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">@lang('Application Configuration')</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('apsetting.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('item_name') has-danger @enderror">
                                    <label class="control-label">@lang('Item Name') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="item_name" value="{{ old('item_name',$data->item_name) }}" id="item_name" type="text" placeholder="@lang('Type Your Item Name Here')" required>
                                    @error('item_name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('item_short_name') has-danger @enderror">
                                    <label class="control-label">@lang('Item Short Name') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="item_short_name" value="{{ old('item_short_name',$data->item_short_name) }}" id="item_short_name" type="text" placeholder="@lang('Type Your Item Short Name Here')" required>
                                    @error('item_short_name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('company_name') has-danger @enderror">
                                    <label class="control-label">@lang('Company Name') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="company_name" value="{{ old('company_name',$data->company_name) }}" id="company_name" type="text" placeholder="@lang('Type Your Company Name Here')" required>
                                    @error('company_name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('company_email') has-danger @enderror">
                                    <label class="control-label">@lang('Company Email') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="company_email" value="{{ old('company_email',$data->company_email) }}" id="company_email" type="text" placeholder="@lang('Type Your Company Email Here')" required>
                                    @error('company_email')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('language') has-danger @enderror">
                                    <label class="control-label">@lang('Deafult Language')</label>
                                    <select class="form-control" name="language" id="language">
                                        @php
                                            $defaultLang = env('LOCALE_LANG', 'en');
                                        @endphp
                                        @foreach($getLang as $key => $value)
                                            <option value="{{ $key }}" {{ old('language', $defaultLang) == $key ? 'selected' : '' }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('language')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('time_zone') has-danger @enderror">
                                    <label class="control-label">@lang('Time Zone')</label>
                                    <select class="form-control" name="time_zone" id="time_zone">
                                        @foreach($timezone as $key => $value)
                                            <option value="{{ $key }}" {{ old('time_zone', $data->time_zone) == $key ? 'selected' : '' }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('time_zone')
                                        <div class="form-control-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('logo') has-danger @enderror">
                                    <label class="control-label">@lang('Logo')</label>
                                    <input id="logo" class="dropify" name="logo" value="{{ old('logo') }}" type="file" data-allowed-file-extensions="png" data-max-file-size="2024K" />
                                    <p>@lang('Max Size: 2mb, Allowed Format: png')</p>
                                    @error('logo')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('favicon') has-danger @enderror">
                                    <label class="control-label">@lang('Favicon')</label>
                                    <input id="favicon" class="dropify" name="favicon" value="{{ old('favicon') }}" type="file" data-allowed-file-extensions="png" data-max-file-size="2024K" />
                                    <p>@lang('Max Size: 500kb, Allowed Format: png')</p>
                                    @error('favicon')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-12">
                                <div class="form-group @error('address') has-danger @enderror">
                                    <label class="control-label">@lang('Company Address')</label>
                                    <div id="company_address"></div>
                                    <input type="hidden" name="address" value="{{ old('address',$data->company_address) }}" id="address">
                                    @error('address')
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
                        <a href="{{ route('dashboard') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('script.application.js')
@endsection
