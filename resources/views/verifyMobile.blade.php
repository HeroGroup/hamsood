<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}} | شماره موبایل</title>
    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        .full-height {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
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
<div class="full-height">
    <div style="flex:1;display: flex;flex-direction: column;justify-content: flex-end;align-items: center;">
        <div style="flex:1;margin-top:100px;">
            <img src="images/account_circle.png" width="170" height="170" />
        </div>
        <div style="flex:1;color:#222;margin-top:20px;">
            <p>جهت ثبت نام در خرید گروهی</p>
            <p>شماره تلفن همراه خود را وارد کنید</p>
        </div>
    </div>
    <form action="{{route('verifyMobile')}}" method="post" style="flex:1;display: flex;flex-direction: column;">
        @csrf
        <div style="flex:1;">
            <div class="input-container">
                <i class="fa fa-fw fa-mobile icon"></i>
                <input class="input-field" type="text" name="mobile" maxlength="11">
            </div>
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif
        </div>
        <div style="flex:1;width:100%;margin-top:-50px;">
            <button style="width: 100%; background-color:#64498E;border:none;border-radius:5px;color:white;padding: 10px 0;margin-top:10px;" type="submit">
                ارسال
            </button>
        </div>
    </form>
</div>
</body>
</html>
