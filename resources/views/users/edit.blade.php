@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="m-b-0 text-white">@lang('Edit User')</h4>
            </div>
            <div class="card-body">
                <form id="userQuickForm" action="{{ route('users.update', $myUser) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="control-label">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="name" value="{{ old('name', $myUser->name) }}" id="name" type="text" placeholder="@lang('Type Your Name Here')" required>
                                    @error('name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('email') has-danger @enderror">
                                    <label class="control-label">@lang('Email') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="email" value="{{ old('email', $myUser->email) }}" id="email" type="text" placeholder="@lang('Type Your Email Here')" required>
                                    @error('email')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('password') has-danger @enderror">
                                    <label class="control-label">@lang('Password') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="password" value="{{ old('password') }}" id="password" type="text" placeholder="@lang('Type Your Password Here')">
                                    @error('password')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <small id="name" class="form-text text-muted">@lang('Leave Blank For Remain Unchanged')</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('password_confirmation') has-danger @enderror">
                                    <label class="control-label">@lang('Confirm Password') <b class="ambitious-crimson">*</b></label>
                                    <input class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" type="text" placeholder="@lang('Type Your Confirm Password Here')">
                                    @error('password_confirmation')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <small id="name" class="form-text text-muted">@lang('Leave Blank For Remain Unchanged')</small>
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('role_for') has-danger @enderror">
                                    <label class="control-label">@lang('User For')</label>
                                    <select id="role_for" class="form-control custom-select" name="role_for">
                                        <option value="1" {{ old('role_for', $roleFor->role_for) == 1 ? 'selected' : '' }} >@lang('General User')</option>
                                        <option value="0" {{ old('role_for', $roleFor->role_for) == 0 ? 'selected' : '' }} >@lang('System User')</option>
                                    </select>
                                    @error('role_for')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('phone') has-danger @enderror">
                                    <label class="control-label">@lang('Phone')</label>
                                    <input class="form-control" name="phone" value="{{ old('phone',$myUser->phone) }}" id="phone" type="text" placeholder="@lang('Type Phone Number Here')">
                                    @error('phone')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div id="staff_block">
                                    <div class="form-group @error('staff_roles') has-danger @enderror">
                                        <label class="control-label">@lang('General Role')</label>
                                        <select id="staff_roles" class="form-control custom-select" name="staff_roles">
                                            @foreach($staffRoles as $key => $role)
                                                <option value="{{$key}}" {{ old('staff_roles', $roleFor->name) == $key ? 'selected' : ''  }}>{{$role}}</option>
                                            @endforeach
                                        </select>
                                        @error('staff_roles')
                                            <small class="form-control-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div id="user_block">
                                    <div class="form-group @error('user_roles') has-danger @enderror">
                                        <label class="control-label">@lang('System Role')</label>
                                        <select id="user_roles" class="form-control custom-select" name="user_roles">
                                            @foreach($userRoles as $key => $role)
                                                <option value="{{$key}}" {{ old('user_roles', $roleFor->name) == $key ? 'selected' : '' }}>{{$role}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_roles')
                                            <small class="form-control-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('status') has-danger @enderror">
                                    <label class="control-label">@lang('Status')</label>
                                    <select id="status" class="form-control custom-select" name="status">
                                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : ''  }}>@lang('Active')</option>
                                        <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : ''  }}>@lang('Inactive')</option>
                                    </select>
                                    @error('status')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('Photo') has-danger @enderror">
                                    <label class="control-label">@lang('Photo')</label>
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
                            <div class="col-md-6">
                                <div class="form-group @error('address') has-danger @enderror">
                                    <label class="control-label">@lang('Address')</label>
                                    <div id="edit_input_address"></div>
                                    <input type="hidden" name="address" value="{{ old('address',$user->address) }}" id="address">
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
                        <a href="{{ route('users.index') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('script.users.edit.js');
@endsection
