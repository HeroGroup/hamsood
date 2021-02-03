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
            /* width: 100%; */
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
            /* width: 100%; */
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
            <img src="images/verify_token.png" width="150" height="150" />
        </div>
        <div style="flex:1;color:#222;margin-top:50px;">
            <p>کد ورود به شماره</p>
            <p>{{session('mobile')}} پیامک شد</p>
            <p>کد را وارد کنید</p>
        </div>
    </div>
    <form action="{{route('verifyToken')}}" method="post">
        @csrf
        <div style="display:flex;justify-content:center;">
            <div class="input-container">
                <img src="/images/keyboard.png" width="36" height="36" class="icon" />
                <input class="input-field" type="text" name="token" maxlength="4" style="padding-top:5px;padding-bottom:5px;text-align: center;">
            </div>
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif

        </div>
        <div style="width:100%;margin-top:20px;">
            <div style="margin-top:10px;text-align: center;color:#9b59b6;">
                <a id="resend" href="#" style="cursor: not-allowed;">ارسال مجدد</a>
                <div id="resend-text" style="display:inline-block;">
                  <span> بعد از </span>
                  <span id="remaining-time"></span>
                  <span> ثانیه</span>
                </div>
              </div>

              <div style="margin-top:20px;text-align: center;">
                  <a href="#">شرایط و قوانین</a>
              </div>

              <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn btn-success" style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;" type="submit">
                  ورود و پذیرش شرایط و قوانین
                </button>
              </div>
        </div>
    </form>
</div>
<script>
  window.onload = function() {
    var timer = parseInt("{{$remainingTime}}");
    document.getElementById("remaining-time").innerHTML = timer;

    var timerInterval = setInterval(function() {
      timer--;

      if (timer > 0) {
        document.getElementById("remaining-time").innerHTML = timer;
      } else {
        clearInterval(timerInterval);
        document.getElementById("resend").href = "/verifyMobile";
        document.getElementById("resend-text").style.display = "none";
        document.getElementById("resend-text").style.cursor = "pointer";
      }
    }, 1000);
  };
</script>
</body>
</html>
