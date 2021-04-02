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
            <input type="text" name="name" id="name" value="{{$customer->name}}" placeholder="نام و نام خانوادگی" class="name-input" />
        </div>
        <div style="margin-top:15px;color:#222;padding:15px;">
            <div>
                <label for="gender">جنسیت</label>
            </div>
            <div style="display:flex;">
                @foreach(config('enums.gender') as $key=>$gender)
                    <div style="flex:1;">
                        <input type="radio" id="{{$key}}" name="gender" value="{{$key}}" @if($customer->gender==$key) checked @endif>
                        <label for="male">{{$gender}}</label>
                    </div>
                @endforeach
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

    $("input[name=name]").on("input", function() {
        activateSubmitButton();
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
</script>
@endsection
