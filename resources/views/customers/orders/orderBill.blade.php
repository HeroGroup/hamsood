@extends('layouts.orderItem', ['order' => $order, 'selected' => 'bill'])
@section('tab-content')
<div style="margin:5px 10px;">

    @if($order->status == 1)
    <div class="payback" style="background-color:orange;">
        منتظر تسویه نهایی
    </div>
    @elseif($order->status == 2 || $order->status == 11)
    <div class="payback" style="background-color:#008B44;">
        @if($order->items()->sum('extra_discount') > 0)
            @if($order->payment_method!=1)
                تسویه حساب نهایی انجام شد و مبلغ {{number_format($order->items()->sum('extra_discount'))}} تومان به کیف پول شما برگشت داده شد
            @else
                تسویه حساب نهایی انجام شد و مبلغ {{number_format($order->items()->sum('extra_discount'))}} تومان از صورتحساب شما کسر شد.
            @endif
        @else
            تسویه حساب نهایی انجام شد
        @endif
    </div>
    @endif

    @component('components.orderBill', [
        'realPrice' => $order->total_price+$order->discount,
        'yourPrice' => $order->total_price-$order->items()->sum('extra_discount'),
        'shippmentPrice' => $order->shippment_price,
        'yourProfit' => $order->discount+$order->items()->sum('extra_discount'),
        'yourPayment' => $order->total_price+$order->shippment_price-$order->items()->sum('extra_discount')
    ])@endcomponent

    <hr />
    <div style="display:flex;padding:0 10px;justify-content:space-between">
        <p>روش پرداخت</p>
        <p style="font-size:1.1em;font-weight:bold;">{{config('enums.payment_method.'.$order->payment_method)}}</p>
    </div>
</div>
@endsection
