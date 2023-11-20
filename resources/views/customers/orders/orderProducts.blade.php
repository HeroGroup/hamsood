@extends('layouts.orderItem', ['order' => $order, 'selected' => 'products'])
@section('tab-content')

    @foreach($order->items as $item)
    <div style="text-align:center;margin:10px;display:flex;">
        <div style="flex:1;">
            <h4>{{$item->availableProduct->product->name}}</h4>
            <img src="{{$item->availableProduct->product->image_url}}" width="50" height="50" />
            <label style="padding: 5px 10px;background-color:#eee;border-radius:5px;">{{$item->weight}} کیلو</label>
        </div>
        {{--<p style="padding:0 25px;">توضیحات: <?php echo $item->availableProduct->product->description; ?></p>--}}
        <div style="flex:1;">
            @component('components.productPrice', ['availableProduct' => $item->availableProduct, 'nextDiscount' => (($item->discount+($item->extra_discount/$item->weight)) / $item->real_price)*100, 'weight' => $item->weight])@endcomponent
        </div>
    </div>
    <hr>
    @endforeach

@endsection
