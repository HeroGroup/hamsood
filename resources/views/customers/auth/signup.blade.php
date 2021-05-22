@extends('layouts.customer', ['pageTitle' => 'ورود کد معرف', 'withNavigation' => true])
@section('content')

    <div class="container" style="text-align:center;margin-bottom:100px;">
        <div style="margin-top:70px;">
            <div>
                <img src="/images/not_entered.png" width="150" height="150" />
            </div>
            <div style="flex:1;color:#222;margin-top:10px;">
                <p>جهت وارد شدن در فروشگاه اینترنتی</p>
                <p>خرید گروهی <b>همسود</b></p>
                <p><b>کد معرف</b> خود را وارد کنید</p>
            </div>
        </div>
        <div>
            <form action="{{route('verifyInvitor')}}" method="post" id="submit-share-code-form">
                @csrf
                <input type="hidden" name="mobile" value="{{$mobile}}" />
                <div style="display:flex;justify-content:center;">
                    <div class="input-container">
                        <i class="fa fa-fw fa-user icon" style="font-size:32px;"></i>
                        <input class="input-field" type="text" name="share_code" value="{{old('share_code')}}" placeholder="کد معرف" maxlength="5" inputmode="numeric" required />
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
                            onclick="submitForm()"
                            id="submit-button">
                        مرحله بعد
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function submitForm() {
            // check if inputs have value
            var shareCode = $("input[name=share_code]");
            if (shareCode.val().length !== 5) {
                shareCode.parent().css({"border":"1px solid red"});
            } else {
                $("#submit-button").prop("disabled",true);
                document.getElementById("submit-share-code-form").submit();
            }
        }
    </script>
@endsection
