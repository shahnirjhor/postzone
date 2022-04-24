@extends('layouts.layout')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('Facebook List')</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">
        <a href="{{ route('facebook-apps.create') }}" type="button" class="btn btn-info">
            <i class="fa fa-plus-circle"></i> @lang('Add Facebook App')
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('Facebook App List')
                    <button class="btn btn-default float-right" data-toggle="collapse" href="#filter"><i class="icon-Magnifi-Glass2"></i> @lang('Filter')</button>
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
                                            <label>@lang('App Name')</label>
                                            <input type="text" name="app_name" class="form-control" value="{{ request()->app_name }}" placeholder="@lang('App Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Api Id')</label>
                                            <input type="text" name="api_id" class="form-control" value="{{ request()->api_id }}" placeholder="@lang('Api Id')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('facebook-apps.index') }}" class="btn btn-secondary">@lang('Clear')</a>
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
                                <th>@lang('App Name')</th>
                                <th>@lang('Api Id')</th>
                                <th>@lang('Token Validity')</th>
                                <th class="text-center">@lang('Status')</th>
                                @canany(['user-update', 'user-delete'])
                                    <th data-orderable="false" class="text-center">@lang('Actions')</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apps['data'] as $app)
                                <tr>
                                    <td>{{ $app['id'] }}</td>
                                    <td>{{ $app['app_name'] }}</td>
                                    <td>{{ $app['api_id'] }}</td>
                                    <td>
                                        @if($app['token_validity'] == 'valid')
                                            <span class="badge badge-success">@lang('Valid')</span>
                                        @elseif ($app['token_validity'] == 'expired')
                                            <span class="badge badge-warning">@lang('Expired')</span>
                                        @else
                                            <span class="badge badge-danger">@lang('Invalid')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($app['status'])
                                            <span class="badge badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('facebook-apps.fbLogin', $app['id']) }}" data-toggle="tooltip" data-original-title="Facebook Login"> <i class="fa fa-sign-in text-inverse m-r-10"></i> </a>
                                        <a href="{{ route('facebook-apps.edit', $app['id']) }}" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <a href="javascript:void(0)" data-href="{{ route('facebook-apps.destroy', $app['id']) }}" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $apps->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.delete_modal')
@include('script.users.index.js')
@endsection
