@extends('layouts.customer', ['pageTitle' => 'ورود/ثبت نام'])
@section('content')
<style>
.custom-btn {
    background-color:#eee;
    border-radius:5px;
    padding:5px 10px;
    text-decoration: none;
    color:#222;
}
.custom-btn:hover {
    color:#222;
    text-decoration: none;
}
</style>
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
    <form action="{{route('verifyToken')}}" method="post" id="submit-code-form">
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
            <div style="margin-top:10px;color:#9b59b6;display:flex;">
                <div style="flex:2;text-align:right;">
                    <a href="#" class="custom-btn" id="resend" style="font-size:12px;color:gray;cursor:not-allowed;display:inline-block;" onclick="resend('{{$mobile}}')">ارسال مجدد</a>
                    &nbsp;
                    <div id="resend-text" style="display:inline-block;">
                      <span> بعد از </span>
                      <span id="remaining-time"></span>
                      <span> ثانیه</span>
                    </div>
                </div>
                <div style="flex:1;text-align:right;">
                    <a class="custom-btn" style="font-size:12px;" href="{{route('customers.verifyMobile')}}">تغییر شماره</a>
                </div>
            </div>

              <div style="margin-top:20px;text-align: center;">
                  <a href="/terms" target="_blank">قوانین و مقررات</a>
              </div>

              <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn btn-success" style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;" type="button" onclick="submitForm()" id="submit-button">
                  ورود و پذیرش قوانین و مقررات
                </button>
              </div>
        </div>
    </form>
</div>
<script>
    var timer = 0;
  window.onload = function() {
    timer = parseInt("{{$remainingTime}}");
    document.getElementById("remaining-time").innerHTML = timer;

    var timerInterval = setInterval(function() {
      timer--;

      if (timer > 0) {
        document.getElementById("remaining-time").innerHTML = timer;
      } else {
        clearInterval(timerInterval);
        // document.getElementById("resend").href = "{{route('customers.verifyMobile')}}";
        document.getElementById("resend").style.color = "#222";
        document.getElementById("resend").style.cursor = "pointer";
        document.getElementById("resend-text").style.display = "none";
      }
    }, 1000);
  };

  function resend(mobile) {
      if (timer <= 0) {
          $.ajax("{{route('verifyMobile')}}", {
              type:"post",
              data: {
                  ajax: true,
                  mobile: mobile
              },
              success: function(response) {
                  if (response.status) {
                      //
                  } else {
                      //
                  }
              }
          });
      }
  }

  function submitForm() {
      $("#submit-button").prop("disabled",true);
      document.getElementById("submit-code-form").submit();
  }
</script>
