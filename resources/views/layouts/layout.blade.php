<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>
        {{ $ApplicationSetting->item_short_name }}
        @if (isset($title) && !empty($title))
            {{ " | ".$title }}
        @endif
    </title>
    @include('thirdparty.css_back')
    @yield('one_page_css')
    @include('thirdparty.js_back')
    @yield('one_page_js')
</head>
<body class="fix-header card-no-border fix-sidebar">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
        </div>
    </div>
    <div id="main-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
    @include('thirdparty.js_back_footer')
</body>
</html>
