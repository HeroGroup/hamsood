@extends('layouts.customer', ['pageTitle' => 'نوع پرداخت', 'withNavigation' => true])
@section('content')
<style>
    .price-container {
        display:flex;
        justify-content:space-between;
        background-color:#eee;
        border-radius:5px;
        color:#222;
        padding:10px 15px;
        margin:120px 20px 30px 20px;
    }
    .payment-method {
        border:1px solid lightgray;
        border-radius:5px;
        margin: 20px 10px;
        padding: 10px 15px;
        cursor:pointer;
        background-color:white;
        color:#222;
    }
    .payment-active {
        border-color:#31AC6B;
    }
    .payment-inactive {
        border-color:lightgray;
        /*cursor:not-allowed;*/
        /*color:lightgray;*/
        /*margin-bottom:5px;*/
    }
    .payment-inactive-description {
        color:gray;
        margin-right:20px;
        margin-bottom: 20px;
    }
</style>

<div style="margin:70px 0;">
    @if(isset($balance) && $balance>0)
    <div style="border:1px solid lightgray;border-radius:5px;color:#222;margin:10px;padding:10px;">
        <div style="display:flex;flex-direction:row;padding:5px;">
            <div style="flex:1">مبلغ صورتحساب</div>
            <div style="flex:1;text-align:left;">{{number_format($paymentAmount)}} تومان</div>
        </div>

        <div style="display:flex;flex-direction:row;background-color:#008B44;color:white;margin:5px 0;padding:5px;border-radius:5px;">
            <div style="flex:1">موجودی کیف پول</div>
            <div style="flex:1;text-align:left;">{{number_format($balance)}} تومان</div>
        </div>

        <div style="display:flex;flex-direction:row;padding:5px;">
            <div style="flex:1">مبلغ قابل پرداخت</div>
            <div style="flex:1;text-align:left;">{{$paymentAmount > $balance ? number_format($paymentAmount-$balance) : 0}} تومان</div>
        </div>
    </div>
    <p style="color:red;visibility:visible;margin:0 10px;" id="use-wallet-warning">موجودی کیف پول فقط در <b>پرداخت اینترنتی</b> قابل استفاده است.</p>
    @endif

    <form method="post" action="{{route('customers.finalizeOrder')}}" id="final-form">
        @csrf
        <input type="hidden" name="amount" value="{{$paymentAmount>$balance ? $paymentAmount-$balance : 0 }}" />

        @if(!isset($balance) || (isset($balance) && $paymentAmount > $balance))
            <input type="hidden" name="payment_method" value="2" />
            <div class="payment-method payment-inactive" data-val="1">پرداخت در محل</div>
            <!--<div class="payment-inactive-description">در حال حاضر پرداخت در محل فعال نمی باشد.</div>-->
            <div class="payment-method payment-active" data-val="2">پرداخت اینترنتی</div>
            <!--<div class="payment-inactive-description">در حال حاضر پرداخت اینترنتی فعال نمی باشد.</div>-->
            <div class="online-payment-methods">
                @component('components.onlinePaymentMethods')@endcomponent
            </div>
        @else
            <input type="hidden" name="payment_method" value="4" />
        @endif
    </form>

</div>

<div style="position:fixed;bottom:0;left:0;width:100%;background-color:white;">
    <button type="button" class="btn confirm-button" onclick="finalSubmit()" id="submit-button">
        تايید نهایی
    </button>
</div>

<script>
    $(".payment-method").on("click", function() {
        $(".payment-method").removeClass("payment-active");
        $(".payment-method").addClass("payment-inactive");
        $(this).removeClass("payment-inactive");
        $(this).addClass("payment-active");

        var paymentMethod = $(this).attr("data-val");
        $("input[name=payment_method]").val(paymentMethod);
        console.log($("input[name=payment_method]").val());
        var onlinePaymentMethods = $(".online-payment-methods"),
            walletWarning = $("#use-wallet-warning");
        if (paymentMethod === "2") {
            onlinePaymentMethods.css({"display":"bock"});
            // walletWarning.css({"visibility":"visible"});
        } else {
            onlinePaymentMethods.css({"display":"none"});
            // walletWarning.css({"visibility":"hidden"});
        }
    });

    function finalSubmit() {
        $("#submit-button").prop("disabled",true);
        document.getElementById("final-form").submit();
    }
</script>

@endsection
