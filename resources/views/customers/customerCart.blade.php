@extends('layouts.customer', ['pageTitle' => 'سبد خرید', 'withNavigation' => true])
@section('content')
<style>
.plus-minus {
    background-color: white;
    font-size:26px;
    box-shadow: 0 0 3px #888888;
    padding:0 12px;
}

.submit-order-button {
    width:100%;
    padding: 15px 0;
    border-radius:0;
    font-size:20px;
    background-color:#64498E;
    color:white;
}
</style>
    <div style="margin:70px 10px;color:#222;">
        @foreach($cartItems as $cartItem)
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;">
            <div style="display:flex;flex-direction:row;padding:10px;">
                <div style="flex:1;">
                    <img src="{{$cartItem->availableProduct->product->image_url}}" style="width:100%;border:1px solid lightgray;border-radius:10px;padding:5px;" />
                </div>
                <div style="flex:2;">
                    <div style="text-align:center;">
                        <h4 style="margin-top:0;padding-top:0;">{{$cartItem->availableProduct->product->name}}</h4>
                        <div style="margin-top:20px;text-align:right;padding-left:15px;padding-right:15px;font-size:12px;">
                            توضیحات: <?php echo $cartItem->availableProduct->product->description ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction:row;padding:10px;vertical-align:center;">
                <div style="flex:1;text-align:center;">
                    <button style="padding:0;border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;width:35px;border-radius:5px;font-size:20px;font-weight:bold;" onclick="addWeight('{{$cartItem->availableProduct->id}}', 4)">+</button>
                    <span id="weight-{{$cartItem->availableProduct->id}}" style="margin:0 5px;font-size:20px;">{{$cartItem->weight}}</span>
                    <button id="subtract-{{$cartItem->availableProduct->id}}" style="padding:0;border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;width:35px;border-radius:5px;font-size:20px;font-weight:bold;" onclick="subtractWeight('{{$cartItem->availableProduct->id}}')">
                        @if($cartItem->weight > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                    </button>
                    <h6 style="color:red;padding:8px 0;">سفارش حداقل ۱ کیلو و حداکثر ۴ کیلو</h4>
                </div>
                <div style="flex:2;">
                    @component('components.productPrice', ['availableProduct' => $cartItem->availableProduct, 'nextDiscount' => $cartItem->discount])@endcomponent
                </div>
            </div>
        </div>
        @endforeach
        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <a class="btn submit-order-button" href="{{route('customers.orderFirstStep', ['weight' => 1])}}">
                ثبت سفارش
            </a>
        </div>
    </div>

    <script src="/js/custom.js" type="text/javascript"></script>
@endsection
