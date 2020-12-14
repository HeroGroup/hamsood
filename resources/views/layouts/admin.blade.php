<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="contor control">
    <meta name="author" content="nHero">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>

    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="/css/rtl/sb-admin-2.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.timepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">

    <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
</head>
<body>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layouts.topBar')
            @include('layouts.sidebar')
        </nav>

        <div id="page-wrapper">

            <!-- Page Heading -->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        {{$pageTitle}}
                        @if(isset($newButton) && $newButton)
                            <a class="pull-left btn btn-primary" href="{{$newButtonUrl}}">
                                <i class="fa fa-fw fa-plus"></i> {{$newButtonText}}
                            </a>
                        @endif
                    </h1>
                </div>
            </div>

            @if(\Illuminate\Support\Facades\Session::has('message'))
                @component('components.alert', [
                    'message' => \Illuminate\Support\Facades\Session::get('message'),
                    'type' => \Illuminate\Support\Facades\Session::get('type')])
                @endcomponent
            @endif

            @yield('content')

        </div>
    </div>

    <script src="/js/jquery.timepicker.js" type="text/javascript"></script>
    <script src="/js/datepair.js" type="text/javascript"></script>
    <script src="/js/popper.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/metisMenu/metisMenu.min.js" type="text/javascript"></script>
    <script src="/js/sb-admin-2.js" type="text/javascript"></script>
    <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    <script src="/js/custom.js" type="text/javascript"></script>
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.custom_date_picker').pDatepicker({
                initialValue: false,
                format: 'YYYY/MM/DD',
                autoClose: true,
                // minDate: new persianDate()
            });
        })
    </script>
</body>
</html>
