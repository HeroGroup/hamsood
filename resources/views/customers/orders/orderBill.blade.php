@extends('layouts.orderItem', ['order' => $order, 'selected' => 'bill'])
@section('tab-content')
<div style="margin:10px;">
    @component('components.orderBill', [
        'realPrice' => $order->items()->first()->weight * $order->items()->first()->availableProduct->price,
        'yourPrice' => $order->total_price,
        'shippmentPrice' => $order->shippment_price,
        'yourProfit' => $order->discount,
        'yourPayment' => $order->total_price
    ])@endcomponent
</div>
@endsection
