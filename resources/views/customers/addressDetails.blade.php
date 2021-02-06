@extends('layouts.customer', ['pageTitle' => 'آدرس محل دریافت کالا', 'withNavigation' => true])
@section('content')
<div class="dark-overlay">
    <div class="overlay-container">
        <img src="/images/back_icon.png" width="12" height="22" style="cursor:pointer;transform: rotate(180deg);" />
        &nbsp;
        <span style="font-size:22px;">جزئیات آدرس</span>
        <form method="post" action="{{route('customers.postAddressDetail')}}">
            @csrf
            <input type="hidden" name="neighbourhood_id" value="{{$neighbourhood->id}}" />
            @if(isset($address) && $address > 0)
                <input type="hidden" name="id" value="{{$address}}" />
            @endif
            <div>
                <p style="padding-top:15px; padding-right:5px;">{{$neighbourhood->name}}</p>
                <textarea name="details" id="details" rows="4" class="form-control" onkeyup="enterDetails(this.value)" placeholder="مثلا خیابان مهر، کوچه ۲، پلاک ۱۳۶، واحد ۲">{{$details}}</textarea>
            </div>
            <div style="padding:25px 40px;;background-color:white;position:fixed;bottom:0;left:0;width:100%;z-index:6;display:flex;justify-content:space-between;">
                <button type="submit" class="btn inactive" disabled style="width:100px;" id="confirm-button">تائید</button>
                <button class="btn" onclick="event.preventDefault(); window.history.back();" style="width:100px;color:#222;background-color:white;">انصراف</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".overlay-container").css({"height":"50%"});

        if (document.getElementById("details").value.length >= 5)
            activateConfirmButton();
        else
            disableConfirmButton();
    });
    function enterDetails(val) {
        if (val.length >= 5) {
            activateConfirmButton();
        } else {
            disableConfirmButton();
        }
    }

    function activateConfirmButton() {
        $("#confirm-button").removeClass("inactive").addClass("active");
        $("#confirm-button").prop("disabled",false);
    }

    function disableConfirmButton() {
        $("#confirm-button").removeClass("active").addClass("inactive");
        $("#confirm-button").attr("disabled",true);
    }
</script>
@endsection
