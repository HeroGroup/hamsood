@extends('layouts.customer', ['pageTitle' => 'ورود/ثبت نام'])
@section('content')

<div class="container" style="text-align:center;margin-bottom:100px;">
    <div style="margin-top:20px;">
        <div>
            <img src="/images/verify_mobile.png" width="150" height="150" />
        </div>
        <div style="flex:1;color:#222;margin-top:50px;">
            <p>جهت وارد شدن در فروشگاه اینترنتی</p>
            <p>خرید گروهی <b>همسود</b></p>
            <p>شماره تلفن همراه خود را وارد کنید</p>
        </div>
    </div>
    <div>
        <form action="{{route('verifyMobile')}}" method="post" id="submit-mobile-form">
            @csrf
            <div style="display:flex;justify-content:center;">
                <div class="input-container">
                    <i class="fa fa-fw fa-mobile icon" style="font-size:22px;"></i>
                    <input class="input-field" type="text" name="mobile" value="{{old('mobile')}}" placeholder="شماره موبایل" maxlength="11" inputmode="numeric" autofocus required />
                </div>
            </div>

            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif

            @if(isset($signup))
                <div style="display:flex;justify-content:center;margin-top:15px;">
                    <div class="input-container">
                        <i class="fa fa-fw fa-user icon" style="font-size:22px;"></i>
                        <input class="input-field" type="text" name="share_code" value="{{old('share_code')}}" placeholder="کد معرف" maxlength="5" inputmode="numeric" required />
                    </div>
                </div>
            @endif

            <div style="margin:20px 0;">
                <button id="submit-button"
                        class="btn btn-success"
                        style="width:270px;padding: 10px 0;border-radius:10px;font-size:20px;"
                        type="button"
                        onclick="submitForm()">
                    دریافت کد
                </button>
            </div>

            @if(isset($signup))
            <input type="hidden" name="form_type" value="signup" />

            <div style="text-align:center;color:#222;margin-top:30px;">
                <span>حساب کاربری دارم</span>
                &nbsp;
                <a href="{{route('customers.verifyMobile')}}">ورود</a>
            </div>
            @else
            <input type="hidden" name="form_type" value="login" />
            <div style="text-align:center;color:#222;margin-top:30px;">
                <span>حساب کاربری ندارم</span>
                &nbsp;
                <a href="{{route('customers.signup')}}">ثبت نام</a>
            </div>
            @endif
            {{--<div style="position:fixed;bottom:0;left:0;width:100%;">--}}
                {{--<button class="btn btn-success"--}}
                        {{--style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;"--}}
                        {{--type="button"--}}
                        {{--onclick="submitForm()" id="submit-button">--}}
                    {{--دریافت کد--}}
                {{--</button>--}}
            {{--</div>--}}
        </form>
    </div>
</div>
<script>
function submitForm() {
    // check if inputs have value
    var mobile = $("input[name=mobile]"), shareCode = $("input[name=share_code]");
    if(mobile.val().length !== 11) {
        mobile.parent().css({"border":"1px solid red"});
    } else if ($("input[name=form_type]").val() === "signup" && shareCode.val().length !== 5) {
        shareCode.parent().css({"border":"1px solid red"});
    } else {
        $("#submit-button").prop("disabled",true);
        document.getElementById("submit-mobile-form").submit();
    }
}
</script>
@endsection
