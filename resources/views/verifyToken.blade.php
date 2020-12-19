<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}} | کد تایید</title>
    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <style>
        .input-container {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            width: 100%;
            border: 1px solid #539BE4;
            border-radius:5px;
        }

        .icon {
            padding: 5px 10px;
            color: #539BE4;
            min-width: 50px;
            text-align: center;
            font-size:40px;
        }

        .input-field {
            width: 100%;
            padding: 0 10px;
            color:#222;
            border:none;
        }
    </style>
</head>
<body>
<div class="container" style="text-align:center;">
    <div style="">
        <div style="margin-top:50px;">
            <img src="images/account_circle.png" width="170" height="170" />
        </div>
        <div style="flex:1;color:#222;margin-top:50px;">
            <p><b>کد تایید</b></p>
        </div>
    </div>
    <form action="{{route('verifyToken')}}" method="post">
        @csrf
        <div style="">
            <div class="input-container">
                <input class="input-field" type="text" name="token" maxlength="4" style="padding-top:5px;padding-bottom:5px;text-align: center;">
            </div>
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif

        </div>
        <div style="width:100%;margin-top:20px;">
            <div style="margin-top:10px;text-align: center;">
                <a href="/verifyMobile">ارسال مجدد</a>
            </div>
            <button style="width: 100%; background-color:#64498E;border:none;border-radius:5px;color:white;padding: 15px 0;margin-top:10px;font-size:20px;" type="submit">
                ورود
            </button>
        </div>
    </form>
</div>
</body>
</html>
