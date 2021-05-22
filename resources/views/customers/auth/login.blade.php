@extends('layouts.customer', ['pageTitle' => 'ورود/ثبت نام', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')

    <div class="container" style="text-align:center;margin-bottom:100px;">
        <div style="margin-top:70px;">
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
                        <i class="fa fa-fw fa-mobile icon" style="font-size:32px;"></i>
                        <input class="input-field" type="text" name="mobile" value="{{old('mobile')}}" placeholder="شماره موبایل" maxlength="11" inputmode="numeric" autofocus required />
                    </div>
                </div>

                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <p style="color:red;margin-top:5px;text-align: center;">
                        {{\Illuminate\Support\Facades\Session::get('error')}}
                    </p>
                @endif

                <div style="position:fixed;bottom:0;left:0;width:100%;">
                    <button class="btn btn-success"
                            style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;"
                            type="button"
                            onclick="submitForm()" id="submit-button">
                        مرحله بعد
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function submitForm() {
            // check if inputs have value
            var mobile = $("input[name=mobile]");
            if(mobile.val().length !== 11) {
                mobile.parent().css({"border":"1px solid red"});
            } else {
                $("#submit-button").prop("disabled",true);
                document.getElementById("submit-mobile-form").submit();
            }
        }
    </script>
@endsection
