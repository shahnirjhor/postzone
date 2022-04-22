@extends('layouts.layout')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('User List')</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">
        <a href="{{ route('users.create') }}" type="button" class="btn btn-info">
            <i class="fa fa-plus-circle"></i> @lang('Add User')
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('User List')
                    <button class="btn btn-default float-right" data-toggle="collapse" href="#filter"><i class="icon-Magnifi-Glass2"></i> @lang('Filter')</button>
                    @can('user-export')
                        <a class="btn btn-primary float-right c-margin-right" target="_blank" href="{{ route('users.index') }}?export=1">
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('User ID')</label>
                                            <input type="text" name="id" class="form-control" value="{{ request()->id }}" placeholder="@lang('User ID')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" class="form-control" value="{{ request()->name }}" placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Email')</label>
                                            <input type="text" name="email" class="form-control" value="{{ request()->email }}" placeholder="@lang('Email')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('users.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table id="laravel_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('Id')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Roles')</th>
                                <th class="text-center">@lang('Register Date')</th>
                                <th class="text-center">@lang('Status')</th>
                                @canany(['user-update', 'user-delete'])
                                    <th data-orderable="false" class="text-center">@lang('Actions')</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->getRoleNames()->first() }}</td>
                                    <td>{{ date('d F Y', strtotime($user->created_at)) }}</td>
                                    <td>
                                        @if($user->status)
                                            <span class="badge badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    @canany(['user-update', 'user-delete'])
                                        <td>
                                            @can('user-update')
                                            <a href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                            @endcan
                                            @can('user-delete')
                                            <a href="javascript:void(0)" data-href="{{ route('users.destroy', $user->id) }}" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            @endcan
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.delete_modal')
@include('script.users.index.js')
@endsection
