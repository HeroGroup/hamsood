@extends('layouts.orderItem', ['order' => $order, 'selected' => 'address'])
@section('tab-content')
<div style="padding:5px 20px;">
    <h4>{{$order->neighbourhood->name}}</h4>
    <p>{{$order->address}}</p>
    <hr />

    <h5>تحویل گیرنده: <b>{{$order->customer_name}}</b></h5>

    <hr />

    <div style="display:flex;justify-content:space-between;">
        <p>زمان ارسال</p>
        <div>
            <p>{{$order->delivery_date}}</p>
            <p>ساعت {{$order->delivery_time}}</p>
        </div>
    </div>
</div>
@endsection
