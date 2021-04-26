@extends('layouts.customer', ['pageTitle' => 'مشخصات فردی', 'withNavigation' => true])
@section('content')
<style>
.name-input {
    border:none;
    border-bottom:1px solid lightgray;
    width:100%;
    color:#222;
    padding: 5px 15px;
}
</style>
<form method="post" action="{{route('customers.updateProfile')}}" id="profile-form">
    @csrf
    <div style="margin: 70px 15px;">
        <div style="text-align:center;">
            <img name="profile_image" width="100" height="100" style="border-radius:50px;" @if($customer->gender=="male") src="/images/avatars/male.png" @elseif($customer->gender=="female") src="/images/avatars/female.png" @else src="/images/user_default_image.png" @endif />
        </div>
        <div style="margin-top:15px;">
            <input type="text" name="name" id="name" value="{{$customer->name}}" required placeholder="نام و نام خانوادگی" class="name-input" />
        </div>
        <div style="margin-top:15px;color:#222;padding:15px;">
            <div>
                <label for="gender">جنسیت</label>
            </div>
            <div style="display:flex;">
                @foreach(config('enums.gender') as $key=>$gender)
                    <div style="flex:1;">
                        <input type="radio" id="{{$key}}" name="gender" value="{{$key}}" @if($customer->gender==$key) checked @endif>
                        <label for="{{$key}}">{{$gender}}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="text-align:center;color:#222;margin:20px 30px;">
            <span>جهت دعوت و ثبت نام دوستان خود </span><br>
            <span>و مشارکت آن ها در خرید گروهی، </span><br>
            <span>کد زیر را برای آن ها ارسال نمایید.</span><br>
            <div style="border:1px dashed gray;border-radius:5px;display:flex;justify-content:space-around;padding:5px 10px;margin:15px 0;">
                <span style="font-size:18px;color:gray;">
                    {{$customer->share_code}}
                </span>
                <a style="text-decoration:none;" href="#" onclick="shareCode()">
                    <img src="/images/share_code_icon.png" width="18" height="20" />
                </a>
            </div>
        </div>
    </div>
    <div style="position:fixed;bottom:0;left:0;width:100%;">
        <button type="button" onclick="submitForm()" id="submit-button" class="btn confirm-button" disabled style="color:gray;background-color:#eee;">
            ثبت مشخصات
        </button>
    </div>
</form>

<script>
    function activateSubmitButton() {
        var target = $("#submit-button");
        target.css({"background-color":"#31AC6B","color":"white"});
        target.prop("disabled",false);
    }
    function deActivateSubmitButton() {
        var target = $("#submit-button");
        target.css({"background-color":"#eee","color":"gray"});
        target.prop("disabled",true);
    }

    $("input[name=name]").on("input", function() {
        if($(this).val().length >= 3)
            activateSubmitButton();
        else
            deActivateSubmitButton();
    });

    $("input[type=radio]").on("change", function() {
        activateSubmitButton();
        var gender = $(this).val();
        switch (gender) {
            case "male":
                $("img[name=profile_image]").attr("src","/images/avatars/male.png");
                break;
            case "female":
                $("img[name=profile_image]").attr("src","/images/avatars/female.png");
                break;
            default:
                $("img[name=profile_image]").attr("src","/images/user_default_image.png");
                break;
        }
    });

    function submitForm() {
        var target = $("#submit-button");
        target.css({"color":"gray","background-color":"#eee"});
        target.prop("disabled",true);
        document.getElementById("profile-form").submit();
    }

    const shareCode = async () => {
        const shareData = {
            title: 'ثبت نام در همسود',
            text: 'با استفاده از کد زیر در همسود ثبت نام کنید و در استفاده از تخفیف گروهی سهیم شوید.'+'\n'+"{{$customer->share_code}}"+'\n'+"www.hamsood.com",
        };
        try {
            await navigator.share(shareData)
        } catch(err) {
            // resultPara.textContent = 'Error: ' + err
        }
    };
</script>
@endsection
