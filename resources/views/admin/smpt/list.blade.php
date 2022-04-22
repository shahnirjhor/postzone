@extends('layouts.layout')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('Smtp List')</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">
        <a href="{{ route('smtp.create') }}" type="button" class="btn btn-info">
            <i class="fa fa-plus-circle"></i> @lang('Add New Smtp')
        </a>
    </div>
</div>
@include('partials.errors')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('SMTP Configrution')
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
                                            <label>@lang('Email')</label>
                                            <input type="text" name="email_address" class="form-control" value="{{ request()->email_address }}" placeholder="@lang('Email Address')">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Type')</label>
                                            <select class="form-control" name="smtp_type">
                                                <option value="">--@lang('Select')--</option>
                                                <option value="default" {{ old('smtp_type', request()->smtp_type) === 'default' ? 'selected' : ''  }}>@lang('Default')</option>
                                                <option value="ssl" {{ old('smtp_type', request()->smtp_type) === 'ssl' ? 'selected' : ''  }}>@lang('SSL')</option>
                                                <option value="tls" {{ old('smtp_type', request()->smtp_type) === 'tls' ? 'selected' : ''  }}>@lang('TLS')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('smtp.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table id="laravel_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('Email')</th>
                                <th>@lang('Host')</th>
                                <th>@lang('Port')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Password')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Status')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $list->email_address }}</td>
                                    <td>{{ $list->smtp_host }}</td>
                                    <td>{{ $list->smtp_port }}</td>
                                    <td>{{ $list->smtp_user }}</td>
                                    <td>{{ $list->smtp_password }}</td>
                                    <td>
                                        @if($list->smtp_type == 'ssl')
                                            <span class="badge badge-pill badge-info">@lang('Ssl')</span>
                                        @elseif($list->smtp_type == 'tls')
                                            <span class="badge badge-pill badge-success">@lang('Tls')</span>
                                        @else
                                            <span class="badge badge-pill badge-secondary">@lang('Default')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($list->status == 0)
                                            <span class="badge badge-pill badge-secondary">@lang('Inactive')</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">@lang('Active')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('smtp.edit', $list) }}" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <a href="javascript:void(0)" data-href="{{ route('smtp.destroy', $list) }}" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $lists->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.delete_modal')
@include('script.smtp.js')
@endsection
