@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">@lang('Facebook Login')</h4>
            </div>
            <div class="card-body">
                @if (isset($data['expiredOrNot']) && $data['expiredOrNot']==1)
                    <div class="alert alert-success">
                        <h5 class="text-center"> <i class="fa fa-info"></i> User access token is valid. you can login and get new user access token if you want.<h5>
                    </div>
                @endif
                <h3 class="text-center">
                    <a href="{{$data['loginButton']}}" type="button" class="btn btn-facebook btn-icon btn-lg">
                        <span class="btn-inner--text"><i class="fa fa-facebook"></i> Facebook Login</span>
                    </a>
                </h3>
            </div>
        </div>
    </div>
</div>
@endsection
