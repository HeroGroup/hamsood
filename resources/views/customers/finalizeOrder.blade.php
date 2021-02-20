@extends('layouts.customer', ['pageTitle' => 'صورتحساب', 'withNavigation' => true])
@section('content')
<div style="margin:120px 20px;">
    @component('components.orderBill', [
        'realPrice' => $prices['realPrice'],
        'yourPrice' => $prices['yourPrice'],
        'shippmentPrice' => $prices['shippmentPrice'],
        'shippmentPriceForNow' => $prices['shippmentPriceForNow'],
        'yourProfit' => $prices['yourProfit'],
        'yourPayment' => $prices['yourPayment']+$prices['shippmentPrice']
    ])@endcomponent
</div>
<div style="position:fixed;bottom:0;left:0;width:100%;">
    <a class="btn confirm-button" href="{{route('customers.finializeOrder')}}">
        ثبت نهایی
    </a>
</div>
@endsection
