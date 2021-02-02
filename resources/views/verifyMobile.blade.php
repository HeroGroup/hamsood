<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{env('APP_NAME')}} | شماره موبایل</title>
    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <style>
        .input-container {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            /* width: 70%; */
            border: 1px solid #539BE4;
            border-radius:5px;
            text-align: center;
        }

        .icon {
            padding: 5px 10px;
            color: #222; /* #539BE4; */
            min-width: 50px;
            text-align: center;
            font-size:36px;
        }

        .input-field {
            /* width: 100%; */
            padding: 0 10px;
            color:#222;
            border:none;
        }
    </style>
</head>
<body>
<div class="container" style="text-align:center;">
    <div style="margin-top:50px;">
        <div>
            <img src="images/verify_mobile.png" width="150" height="150" />
        </div>
        <div style="flex:1;color:#222;margin-top:20px;">
            <p>جهت وارد شدن در فروشگاه اینترنتی</p>
            <p>خرید گروهی <b>همسود</b></p>
            <p>شماره تلفن همراه خود را وارد کنید</p>
        </div>
    </div>
    <div>
        <form action="{{route('verifyMobile')}}" method="post">
            @csrf
            <div style="display:flex;justify-content:center;">
                <div class="input-container">
                    <i class="fa fa-fw fa-mobile icon"></i>
                    <input class="input-field" type="text" name="mobile" maxlength="11">
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif
            <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn btn-success" style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;" type="submit">
                    دریافت کد
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
