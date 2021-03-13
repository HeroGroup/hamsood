@extends('layouts.customer', ['pageTitle' =>'کد تایید'])
@section('content')

<div class="container" style="text-align:center;">
    <div style="margin-top:50px;">
        <div>
            <img src="/images/verify_token.png" width="150" height="150" />
        </div>
        <div style="flex:1;color:#222;margin-top:50px;">
            <p>کد ورود به شماره</p>
            <p>{{ isset($mobile) ? $mobile : '-' }} پیامک شد</p>
            <p>کد را وارد کنید</p>
        </div>
    </div>
    <form action="{{route('verifyToken')}}" method="post">
        @csrf
        <div style="display:flex;justify-content:center;">
            <div class="input-container">
                <img src="/images/keyboard.png" width="36" height="36" style="text-align:center;padding:5px;" />
                <input type="hidden" name="mobile" value="{{$mobile}}" />
                <input class="input-field" type="text" name="token" maxlength="4" inputmode="numeric" autofocus style="padding-top:5px;padding-bottom:5px;">
            </div>
        </div>
        @if(\Illuminate\Support\Facades\Session::has('error'))
            <p style="color:red;margin-top:5px;text-align: center;">
                {{\Illuminate\Support\Facades\Session::get('error')}}
            </p>
        @endif
        <div style="width:100%;margin-top:20px;">
            <div style="margin-top:10px;text-align: center;color:#9b59b6;">
                <a id="resend" href="#" style="cursor: not-allowed;color:gray;text-decoration: none;">ارسال مجدد</a>
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
        document.getElementById("resend").href = "{{route('customers.verifyMobile')}}";
        document.getElementById("resend").style.color = "#9b59b6";
        document.getElementById("resend").style.cursor = "pointer";
        document.getElementById("resend-text").style.display = "none";
      }
    }, 1000);
  };
</script>
