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
        <script src="/js/sweetalert2.min.js" type="text/javascript"></script>
    </head>
    <body @if(isset($darkBackground)) style="background-color:#222;" @endif>
        @if(isset($withMenu) && $withMenu)
            @include('layouts.topMenu', ['cartItemsCount' => isset($cartItemsCount) ? $cartItemsCount : 0])
        @elseif(isset($withNavigation) && $withNavigation)
            @include('layouts.topNavigation', ['pageTitle' => $pageTitle, 'backUrl' => isset($backUrl) ? $backUrl : null])
        @endif

        {{--@if(\Illuminate\Support\Facades\Session::has('message'))
            @component('components.alert', [
                'message' => \Illuminate\Support\Facades\Session::get('message'),
                'type' => \Illuminate\Support\Facades\Session::get('type')])
            @endcomponent
        @endif--}}

        @yield('content')
        <script>
            $(document).ready(function() {
                if("{{\Illuminate\Support\Facades\Session::has('message')}}" ? true : false) {
                    Swal.fire({
                      icon: "{{\Illuminate\Support\Facades\Session::get('type')}}" === "danger" ? 'error' : 'success',
                      text: "{{\Illuminate\Support\Facades\Session::get('message')}}",
                      timerProgressBar: true,
                      timer:5000
                    });
                }
            });
        </script>
    </body>
</html>
