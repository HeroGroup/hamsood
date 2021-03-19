@extends('layouts.customer', ['pageTitle' => 'صورتحساب و نوع پرداخت', 'withNavigation' => true])
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
<div style="margin:80px 0;">
    <div class="payment-method" style="border-color:#31AC6B;">پرداخت در محل</div>
    <div class="payment-method payment-inactive">پرداخت اینترنتی</div>
    <div class="payment-inactive-description">در حال حاضر پرداخت اینترنتی فعال نمی باشد.</div>
    <div style="margin:20px 20px 0 20px;">
        @component('components.orderBill', [
            'realPrice' => $prices['realPrice'],
            'yourPrice' => $prices['yourPrice'],
            'shippmentPrice' => $prices['shippmentPrice'],
            'shippmentPriceForNow' => $prices['shippmentPriceForNow'],
            'yourProfit' => $prices['yourProfit'],
            'yourPayment' => $prices['yourPayment']
        ])@endcomponent
    </div>
</div>
    <div style="position:fixed;bottom:0;left:0;width:100%;">
        <form method="post" action="{{route('customers.finalizeOrder')}}">
            @csrf
            <input type="hidden" name="payment_method" value="1" />
            <button type="submit" class="btn confirm-button">
                تايید نهایی
            </button>
        </form>
    </div>
@endsection
