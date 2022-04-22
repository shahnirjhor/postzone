@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">@lang('Create Role')</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="control-label">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="@lang('Role Name')" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('role_for') has-danger @enderror">
                                    <label class="control-label">@lang('Role For')</label>
                                    <select id="role_for" class="form-control custom-select" name="role_for">
                                        <option value="1" {{ old('role_for') == 1 ? 'selected' : '' }} >@lang('General User')</option>
                                        <option value="0" {{ old('role_for') == 0 ? 'selected' : '' }} >@lang('System User')</option>
                                    </select>
                                    @error('role_for')
                                        <small class="form-control-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="user_block">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group @error('price') has-danger @enderror">
                                        <label class="control-label">@lang('Price') <b class="ambitious-crimson">*</b></label>
                                        <input type="text" id="price" class="form-control" name="price" placeholder="@lang('Role Price')" value="{{ old('price') }}">
                                        @error('price')
                                            <small class="form-control-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('validity') has-danger @enderror">
                                        <label class="control-label">@lang('Validity') <b class="ambitious-crimson">*</b></label>
                                        <input type="text" id="validity" class="form-control" name="validity" placeholder="@lang('Validity Day')" value="{{ old('validity') }}">
                                        @error('validity')
                                            <small class="form-control-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row p-t-20 @error('permission') has-danger @enderror">
                            <div class="col-md-2">
                                <label class="control-label @error('permissions') has-danger @enderror">@lang('Permissions') <b class="ambitious-crimson">*</b></label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-control-plaintext">
                                    @php
                                        $lastName = '';
                                    @endphp
                                    @foreach($permissions as $permission)
                                        @if($lastName != $permission->display_name)
                                            @php
                                                $lastName = $permission->display_name;
                                            @endphp
                                            <div role="checkbox" style="padding-top: 5px;">
                                                <h6 class="ambitious-role-margin-extra">{{ $lastName }}</h6>
                                            </div>
                                        @endif
                                        @php
                                            $pname = explode("-", $permission->name);
                                            $display = end($pname);
                                        @endphp
                                        @if($display == 'read')
                                            <input data-checkbox="icheckbox_flat-blue" name="permission[]" id="permission_{{ $permission->id }}" class="check" type="checkbox" value="{{ $permission->id }}" @if(is_array(old('permission')) && in_array($permission->id, old('permission'))) checked @endif>
                                            <label for="permission_{{ $permission->id }}">
                                                {{ $display }}
                                            </label>
                                        @endif
                                        @if($display == 'create')
                                            <input data-checkbox="icheckbox_flat-green" name="permission[]" id="permission_{{ $permission->id }}" class="check" type="checkbox" value="{{ $permission->id }}" @if(is_array(old('permission')) && in_array($permission->id, old('permission'))) checked @endif>
                                            <label for="permission_{{ $permission->id }}">
                                                {{ $display }}
                                            </label>
                                        @endif
                                        @if($display == 'update')
                                            <input data-checkbox="icheckbox_flat-orange" name="permission[]" id="permission_{{ $permission->id }}" class="check" type="checkbox" value="{{ $permission->id }}" @if(is_array(old('permission')) && in_array($permission->id, old('permission'))) checked @endif>
                                            <label for="permission_{{ $permission->id }}">
                                                {{ $display }}
                                            </label>
                                        @endif
                                        @if($display == 'delete')
                                            <input data-checkbox="icheckbox_flat-red" name="permission[]" id="permission_{{ $permission->id }}" class="check" type="checkbox" value="{{ $permission->id }}" @if(is_array(old('permission')) && in_array($permission->id, old('permission'))) checked @endif>
                                            <label for="permission_{{ $permission->id }}">
                                                {{ $display }}
                                            </label>
                                        @endif
                                        @if ($display == 'export')
                                            <input data-checkbox="icheckbox_flat-purple" name="permission[]" id="permission_{{ $permission->id }}" class="check" type="checkbox" value="{{ $permission->id }}" @if(is_array(old('permission')) && in_array($permission->id, old('permission'))) checked @endif>
                                            <label for="permission_{{ $permission->id }}">
                                                {{ $display }}
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                                @error('permission')
                                    <small class="form-control-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <button type="button" class="btn btn-inverse">@lang('Cancel')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('script.roles.create.js')
@endsection
