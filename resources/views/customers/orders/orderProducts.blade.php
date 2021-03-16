@extends('layouts.orderItem', ['order' => $order, 'selected' => 'products'])
@section('tab-content')

    @foreach($order->items as $item)
    <div style="text-align:center;">
        <img src="{{$item->availableProduct->product->image_url}}" width="100" height="100" />
        <h4>{{$item->availableProduct->product->name}}</h4>
        <p style="padding:0 25px;">توضیحات: <?php echo $item->availableProduct->product->description; ?></p>
        <label style="padding: 5px 10px;background-color:#eee;border-radius:5px;">{{$item->weight}} کیلو</label>
        @component('components.productPrice', ['availableProduct' => $item->availableProduct, 'nextDiscount' => ($order->discount / ($order->discount+$order->total_price))*100])@endcomponent
    </div>
    @endforeach

@endsection
