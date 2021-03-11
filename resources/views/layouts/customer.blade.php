<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>همسود | {{$pageTitle}}</title>
        <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
        <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
        <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/css/my.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
        <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <body @if(isset($darkBackground)) style="background-color:#222;" @endif>
        @if(isset($withMenu) && $withMenu)
            @include('layouts.topMenu', ['cartItemsCount' => $cartItemsCount])
        @elseif(isset($withNavigation) && $withNavigation)
            @include('layouts.topNavigation', ['pageTitle' => $pageTitle])
        @endif

        @if(\Illuminate\Support\Facades\Session::has('message'))
            @component('components.alert', [
                'message' => \Illuminate\Support\Facades\Session::get('message'),
                'type' => \Illuminate\Support\Facades\Session::get('type')])
            @endcomponent
        @endif

        @yield('content')

    </body>
  </html>
