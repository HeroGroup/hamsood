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
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;margin-bottom:15px;">
            <div style="display:flex;flex-direction:row;padding:10px;">
                <div style="flex:2;">
                    <img src="{{$cartItem->availableProduct->product->image_url}}" style="width:100%;border:1px solid lightgray;border-radius:10px;padding:5px;" />
                </div>
                <div style="flex:3;">
                    <div style="text-align:center;">
                        <h4 style="margin-top:0;padding-top:0;">{{$cartItem->availableProduct->product->name}}</h4>
                        <div style="margin-top:20px;text-align:right;padding-left:15px;padding-right:15px;font-size:12px;">
                            توضیحات: <?php echo $cartItem->availableProduct->product->description ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction:row;padding:10px;vertical-align:center;">
                <div style="flex:2;text-align:center;">
                    <div style="display:flex;">
                        <button class="add-subtract-button" style="flex:1" onclick="addWeight('{{$cartItem->availableProduct->id}}', 4, true, '{{$cartItem->availableProduct->price}}', {{$cartItem->discount/$cartItem->real_price*100}})">+</button>
                        <span id="weight-{{$cartItem->availableProduct->id}}" style="flex:1;margin:0 5px;font-size:16px;">{{$cartItem->weight}}</span>
                        <button id="subtract-{{$cartItem->availableProduct->id}}" class="add-subtract-button" style="flex:1" onclick="subtractWeight('{{$cartItem->availableProduct->id}}', true, '{{$cartItem->availableProduct->price}}', '{{$cartItem->discount/$cartItem->real_price*100}}')">
                            @if($cartItem->weight > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                        </button>
                    </div>
                    <h6 style="color:red;padding:8px 0;">سفارش حداقل ۱ کیلو و حداکثر ۴ کیلو</h6>
                </div>
                <div style="flex:3;">
                    @component('components.productPrice', ['availableProduct' => $cartItem->availableProduct, 'nextDiscount' => $cartItem->discount/$cartItem->real_price*100, 'weight' => $cartItem->weight])@endcomponent
                </div>
            </div>
        </div>
        @endforeach
        @if($cartItems->count()>0)
        <div style="margin:10px 0;border:1px solid lightgray;border-radius:5px;background-color:#eee;display:flex;color:#222;justify-content:center;align-items:center;text-align:center;">
            <div style="flex:1;">جمع کل</div>
            <div style="flex:2;text-align:center;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0 8px;">
                    <div style="background-color:white;border-radius:5px;width:100px;padding:2px 5px;margin:3px;">قیمت بازار</div>
                    <span id="real-total-price" style="color:gray;">{{number_format($totals['real_total_price'])}}</span>
                    <span style="color:gray;"> تومان</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0 8px;">
                    <div style="background-color:#8A95F5;border-radius:5px;width:100px;padding:2px 5px;margin:3px;">قیمت همسودی</div>
                    <span id="your-total-price" style="font-size:16px;color:#64498F;">{{number_format($totals['your_total_price'])}}</span>
                    <span style="color:#64498F;"> تومان</span>
                </div>
            </div>
        </div>
        @endif
        <div style="border:1px solid #00EFD1;border-radius:5px;text-align:center;">
            <a href="{{route('landing')}}" style="text-decoration:none;color:#222;">
                <img src="/images/new_product_icon.png" width="100" height="100" />
                <h4>ادامه خرید</h4>
            </a>
        </div>
        @if($cartItems->count()>0)
        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <a class="btn submit-order-button" onclick="submitOrder()" href="#">
                ثبت سفارش
            </a>
        </div>
        @endif
    </div>

    @component('components.loader')@endcomponent

    <script src="/js/custom.js" type="text/javascript"></script>
    <script>
        function submitOrder() {
            turnOnLoader();
            window.location.href = "{{route('customers.selectAddress')}}";
        }
    </script>
@endsection
