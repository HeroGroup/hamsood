@extends('layouts.customer', ['pageTitle' => 'کیف پول', 'withNavigation' => true])
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
            flex:1;
            border:1px solid gray;
            border-radius:5px;
            margin:10px;
            padding:5px 10px;
            font-size:16px;
            cursor: pointer;
            background-color: white;
            color:#222;
        }
        .amount-item:hover {
            background-color: #64498E;
            color:white;
        }
    </style>
<div style="margin:70px 0;color:#222;">
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
        <div style="margin:20px 10px;background-color:#eee;border-radius:5px;display:flex;">
            <div style="flex:1;text-align: center;">
                <h4>مبلغ مورد نظر جهت</h4>
                <h4>افزایش اعتبار</h4>
                <div style="color:red;font-size:12px;">حداقل 5,000 تومان</div>
            </div>
            <div style="flex:1;text-align: center;">
                <input type="number" name="amount" id="amount" placeholder="مبلغ" />
                <h3 style="margin-top:5px;">تومان</h3>
            </div>
        </div>

        <div style="display:flex;text-align:center;margin:20px 0;">
            <div class="amount-item" data-val="50000">50,000 تومان</div>
            <div class="amount-item" data-val="20000">20,000 تومان</div>
            <div class="amount-item" data-val="10000">10,000 تومان</div>
        </div>

        <div style="display:flex;text-align:center;">
            @foreach(config('enums.online_payment_methods') as $key=>$method)
                @if($method['active'] == 1)
                <div style="flex:1;border:1px solid lightgray;border-radius:5px;margin: 0 10px;padding:5px 10px;">
                    <input type="radio" id="{{$key}}" name="method" value="{{$key}}">
                    <img src="{{$method['icon']}}" width="20" height="20">
                    <label for="{{$key}}">{{$method['name']}}</label>
                </div>
                @endif
            @endforeach
        </div>
    </form>

    <div style="position:fixed;bottom:0;left:0;width:100%;">
        <button type="button" onclick="pay()" id="submit-button" class="btn confirm-button">
            پرداخت
        </button>
    </div>

</div>
    <script>
        $(document).ready(function() {
            if ($("input[name=amount]").val() >= 5000 && $("input[name=method]:checked").val() > 0)
                activateSubmitButton();
            else
                deActivateSubmitButton();
        });

        $(".amount-item").on("click", function () {
            $("#amount").val($(this).attr("data-val"));
            if($("input[name=method]:checked").val() > 0)
                activateSubmitButton();
        });

        $("input[name=amount]").on("input", function() {
            if ($(this).val() >= 5000 && $("input[name=method]:checked").val() > 0)
                activateSubmitButton();
            else
                deActivateSubmitButton();
        });

        $("input[name=method]").on("change", function() {
            $("input[type=radio]").parent().css({"border-color":"lightgray"});
            $(this).parent().css({"border-color":"#31AC6B"});
            if($("input[name=amount]").val() >= 5000)
                activateSubmitButton();
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
