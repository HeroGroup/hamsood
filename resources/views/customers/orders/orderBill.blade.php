@extends('layouts.orderItem', ['order' => $order, 'selected' => 'bill'])
@section('tab-content')
<div style="margin:10px;">
    @component('components.orderBill', [
        'realPrice' => $order->items()->first()->weight * $order->items()->first()->availableProduct->price,
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
