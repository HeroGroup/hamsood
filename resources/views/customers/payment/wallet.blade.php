@extends('layouts.customer', ['pageTitle' => 'کیف پول', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type=radio]:checked {
            background-color: #31AC6B;
        }

        #amount {
            background-color:#eee;
            border:none;
            border-bottom:2px solid #64498E;
            box-shadow:none;
            font-size:30px;
            width:120px;
            text-align:center;
            padding-bottom:0;
        }
        #amount:focus {
            outline:none !important;
        }
        .amount-item {
            border:1px solid gray;
            border-radius:5px;
            padding:5px 10px;
            font-size:16px;
            cursor: pointer;
            background-color: white;
            color:#222;
            margin:0 10px;
            text-align: center;
        }
        .amount-item:hover {
            background-color: #64498E;
            color:white;
        }
    </style>
<div style="margin:70px 10px;color:#222;">
    <div class="tab-container">
        <a href="{{route('customers.wallet')}}" id="products" class="tab-item selected">افزایش اعتبار</a>
        <a href="{{route('customers.transactions')}}" id="address" class="tab-item">تراکنش های من</a>
    </div>

    <div style="margin:20px 10px;text-align:center;color:gray;border:1px solid lightgray;border-radius:5px;">
        <h2>موجودی کیف پول</h2>
        <h2>{{number_format($balance)}} تومان</h2>
    </div>
    <form method="post" action="{{route('customers.pay')}}" id="pay-form">
        @csrf
        <input type="hidden" name="title" value="افزایش اعتبار" />
        <input type="hidden" name="transaction_type" value="1" />
        <input type="hidden" name="redirect" value="/payment/wallet" />
        <div style="margin:50px 10px;background-color:#eee;border-radius:5px;display:flex;">
            <div style="flex:1;text-align:center;color:#64498E">
                <h4>مبلغ مورد نظر جهت</h4>
                <h4>افزایش اعتبار</h4>
                <div style="color:red;font-size:12px;">حداقل 1,000 تومان</div>
            </div>
            <div style="flex:1;text-align: center;">
                <input type="number" name="amount" id="amount" placeholder="مبلغ" />
                <h3 style="margin-top:5px;">تومان</h3>
            </div>
        </div>

        <div style="display:flex;margin:20px 0;justify-content:space-between;align-items:center;">
            <div class="amount-item" data-val="50000">50,000 تومان</div>
            <div class="amount-item" data-val="20000">20,000 تومان</div>
            <div class="amount-item" data-val="10000">10,000 تومان</div>
        </div>

        @component('components.onlinePaymentMethods')@endcomponent

    </form>

    <div style="position:fixed;bottom:0;left:0;width:100%;z-index:4;background-color:white;">
        <button type="button" onclick="pay()" id="submit-button" class="btn confirm-button">
            پرداخت
        </button>
    </div>

</div>
    <script>
        $(document).ready(function() {
            if ($("input[name=amount]").val() >= 1000 && $("input[name=online_payment_method]:checked").val() > 0)
                activateSubmitButton();
            else
                deActivateSubmitButton();
        });

        $(".amount-item").on("click", function () {
            $("#amount").val($(this).attr("data-val"));
            if($("input[name=online_payment_method]:checked").val() > 0)
                activateSubmitButton();
        });

        $("input[name=amount]").on("input", function() {
            if ($(this).val() >= 1000 && $("input[name=online_payment_method]:checked").val() > 0)
                activateSubmitButton();
            else
                deActivateSubmitButton();
        });

        function pay() {
            deActivateSubmitButton();
            document.getElementById("pay-form").submit();
        }

        function activateSubmitButton() {
            var target = $("#submit-button");
            target.css({"background-color":"#31AC6B","color":"white"});
            target.prop("disabled",false);
        }

        function deActivateSubmitButton() {
            var target = $("#submit-button");
            target.css({"background-color":"lightgray","color":"gray"});
            target.prop("disabled",true);
        }
    </script>
@endsection
