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
<form method="post" action="{{route('customers.updateProfile')}}">
    @csrf
    <div style="margin: 70px 15px;">
        <div style="text-align:center;">
            <img name="profile_image" width="100" height="100" style="border-radius:50px;" @if($customer->gender=="male") src="/images/avatars/male3.png" @elseif($customer->gender=="female") src="/images/avatars/female2.png" @else src="/images/user_default_image.png" @endif />
        </div>
        <div style="margin-top:15px;">
            <input type="text" name="name" id="name" value="{{$customer->name}}" placeholder="نام و نام خانوادگی" class="name-input" />
        </div>
        <div style="margin-top:15px;color:#222;padding:15px;">
            <div>
                <label for="gender">جنسیت</label>
            </div>
            <div style="display:flex;">
                <div style="flex:1;">
                    <input type="radio" id="male" name="gender" value="male" @if($customer->gender=="male") checked @endif>
                    <label for="male">آقا</label>
                </div>
                <div style="flex:1;">
                    <input type="radio" id="female" name="gender" value="female" @if($customer->gender=="female") checked @endif>
                    <label for="female">خانم</label>
                </div>
            </div>
        </div>
    </div>
    <div style="position:fixed;bottom:0;left:0;width:100%;">
        <button type="submit" class="btn confirm-button">
            ثبت مشخصات
        </button>
    </div>
</form>
<script>
    $("input[type=radio]").on("change", function() {
        var gender = $(this).val();
        switch (gender) {
            case "male":
                $("img[name=profile_image]").attr("src","/images/avatars/male3.png");
                break;
            case "female":
                $("img[name=profile_image]").attr("src","/images/avatars/female2.png");
                break;
            default:
                $("img[name=profile_image]").attr("src","/images/user_default_image.png");
                break;
        }
    });
</script>
@endsection
