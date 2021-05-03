@extends('layouts.orderItem', ['order' => $order, 'selected' => 'bill'])
@section('tab-content')
<div style="margin:5px 10px;">
    <div id="payback-status" style="background-color:orange;border-radius:10px;color:white;text-align:center;margin:10px 0;padding:10px;">منتظر تسویه نهایی</div>

    @component('components.orderBill', [
        'realPrice' => $order->total_price+$order->discount,
        'yourPrice' => $order->total_price,
        'shippmentPrice' => $order->shippment_price,
        'yourProfit' => $order->discount,
        'yourPayment' => $order->total_price+$order->shippment_price
    ])@endcomponent

    <hr />
    <div style="display:flex;padding:0 10px;justify-content:space-between">
        <p>روش پرداخت</p>
        <p style="font-size:1.1em;font-weight:bold;">{{config('enums.payment_method.'.$order->payment_method)}}</p>
    </div>
</div>
@endsection
