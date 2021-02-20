@extends('layouts.customer', ['pageTitle' => 'انتخاب نوع پرداخت', 'withNavigation' => true])
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
        margin: 0 20px 20px 20px;
        padding: 10px 15px;
        cursor:pointer;
        background-color:white;
        color:#222;
    }
    .payment-inactive {
        border-color:lightgray;
        cursor:not-allowed;
        color:lightgray;
        margin-bottom:5px;
    }
    .payment-inactive-description {
        color:gray;
        margin-right:20px;
    }
</style>
    <div class="price-container">
        <h4>مبلغ قابل پرداخت</h4>
        <h4 style="color:#539BE4;">{{number_format(session('total_price')+session('shippment_price_for_now'))}} تومان</h4>
    </div>
    <div class="payment-method" style="border-color:#31AC6B;">پرداخت در محل</div>
    <div class="payment-method payment-inactive">پرداخت اینترنتی</div>
    <div class="payment-inactive-description">متاسفانه پرداخت اینترنتی فعال نمی باشد.</div>

    <div style="position:fixed;bottom:0;left:0;width:100%;">
        <form method="post" action="{{route('customers.selectPaymentMethod')}}">
            @csrf
            <input type="hidden" name="payment_method" value="1" />
            <button type="submit" class="btn confirm-button">
                انتخاب نوع پرداخت
            </button>
        </form>
    </div>
@endsection
