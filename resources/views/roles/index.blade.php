@extends('layouts.layout')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('Role List')</li>
            </ol>
        </div>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <a href="{{ route('roles.create') }}" type="button" class="btn btn-info">
                <i class="fa fa-plus-circle"></i> @lang('Add Role')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        @lang('Role List')
                        <button class="btn btn-default float-right" data-toggle="collapse" href="#filter"><i class="icon-Magnifi-Glass2"></i> @lang('Filter')</button>
                        @can('role-export')
                            <a class="btn btn-primary float-right c-margin-right" target="_blank" href="{{ route('roles.index') }}?export=1">
                                <i class="icon-Download-fromCloud"></i> @lang('Export')
                            </a>
                        @endcan
                    </h4>
                    <div class="table-responsive">
                        <br>
                        <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                            <div class="card-body border">
                                <form action="" method="get" role="form" autocomplete="off">
                                    <input type="hidden" name="isFilterActive" value="true">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>@lang('Role Name')</label>
                                                <input type="text" name="name" class="form-control" value="{{ request()->name }}" placeholder="@lang('Role Name')">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>@lang('Role For')</label>
                                                <select class="form-control" name="role_for">
                                                    <option value="">--@lang('Select')--</option>
                                                    <option value="0" {{ old('role_for', request()->role_for) === '0' ? 'selected' : ''  }}>@lang('System User')</option>
                                                    <option value="1" {{ old('role_for', request()->role_for) === '1' ? 'selected' : ''  }}>@lang('General User')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                            @if(request()->isFilterActive)
                                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table id="laravel_datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Validity')</th>
                                    <th class="text-center">@lang('Role For')</th>
                                    <th class="text-center">@lang('Default')</th>
                                    @canany(['role-update', 'role-delete'])
                                        <th class="text-nowrap text-center">@lang('Actions')</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->price }}</td>
                                        <td>{{ $role->validity }}</td>
                                        <td class="text-center">
                                            @if($role->role_for == '1')
                                                <span class="badge badge-pill badge-success">@lang('General User')</span>
                                            @else
                                                <span class="badge badge-pill badge-primary">@lang('System User')</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($role->is_default == '1')
                                                <span class="badge badge-pill badge-info">@lang('Yes')</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">@lang('No')</span>
                                            @endif
                                        </td>
                                        @canany(['role-update', 'role-delete'])
                                            <td class="text-center">
                                                @can('role-update')
                                                    <a href="{{ route('roles.edit', $role) }}" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                @endcan
                                                @can('role-delete')
                                                <a href="javascript:void(0)" data-href="{{ route('roles.destroy', $role) }}" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@include('script.roles.index.js')
@endsection

