@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="text-center">
            <a href="{{$data['loginButton']}}" type="button" class="btn btn-facebook btn-icon btn-lg" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('You must be logged in your facebook account for which you want to refresh your all information')">
                <span class="btn-inner--text"><i class="fa fa-facebook"></i> Facebook Login</span>
            </a>
        </h3>
    </div>
</div>
@if ($data['existingFbAccounts'] != '0')
<div>
    @if ($data['showConnectAccountBox'] == 1)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">@lang('Your Existing Accounts')</h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        @php
            $j=0;
            foreach($data['existingFbAccounts'] as $value) :
        @endphp
        <div class="col-md-6">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-aqua-active" >
                    <h3 class="widget-user-username pull-left con-user-name"><i class="fa fa-facebook"></i> <?php echo $value['name']; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="delete_account btn btn-box-tool" table_id="<?php echo $value['fb_user_table_id']; ?>"><i class="fa fa-trash fa-2x con-user-name"></i></button>
                    </div>
                </div>
                <div class="widget-user-image">
                    <?php $profilePicture="https://graph.facebook.com/me/picture?access_token={$value['user_access_token']}&width=120&height=120"; ?>
                      <img class="img-circle" src="<?php echo $profilePicture;?>" alt="<?php echo $value['name']; ?>">
                </div>
                <div class="box-body">
                    <div class="col-xs-12 con-page-area">
                        @if ($value['need_to_delete'] == 1)
                            <div class='alert alert-danger text-center'><i class='fa fa-close'></i> You have to delete this account.</div>
                        @endif
                        @if ($value['validity'] == 'no')
                            <div class='alert alert-danger text-center'><i class='fa fa-close'></i> Your login validity has been expired.</div>
                        @endif
                        <br/><br/><br/>
                        @foreach ($value['page_list'] as $page_info)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <img src="<?php echo $page_info['page_profile']; ?>" alt="" class='img-thumbnail'>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <p><b>Name : </b> <?php echo $page_info['page_name']; ?></p>
                                <a href="https://www.facebook.com/<?php echo $page_info['page_id'];?>" target="_blank"><i class="fa fa-hand-pointer-o"></i> Visit Page</a>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 text-center">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button table_id="<?php echo $page_info['id']; ?>" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal_break">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @php
            $j++;
            if($j%2 == 0) {
                echo "</div><div class='row'>";
            }
            endforeach;
        @endphp
    </div>
</div>
@endif
@endsection
