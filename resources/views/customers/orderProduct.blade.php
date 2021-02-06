@extends('layouts.customer', ['pageTitle' => 'محصول', 'withNavigation' => true])
@section('content')
<style>
.plus-minus {
    background-color: white;
    font-size:26px;
    box-shadow: 0 0 3px #888888;
    padding:0 12px;
}
.pill-container {
    display:flex;
    justify-content:center;
    margin:10px 25px;
    padding:5px 0;
}
.pill {
    display:inline-block;
    width:100px;
    border-radius:5px;
    padding:5px;
    font-size:12px;
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
    <div style="margin:70px 0;text-align:center;color:#222;">
        <div>
            <img src="{{$product->image_url}}" width="90" height="90" style="border:1px solid lightgray;border-radius:5px;padding:5px;">
        </div>
        <h4 style="text-align:center;">{{$product->name}}</h4>
        <p style="padding:8px 38px;">توضیحات: {{$product->description}}</p>
        <button class="btn plus-minus" onclick="add()">+</button>
        <span id="quantity" style="display: inline-block;width:30px;font-size:22px;padding:0 8px 5px 38px;">1</span><span style="padding-left:8px;font-size:12px;">کیلو</span>
        <button class="btn plus-minus" onclick="subtrack()">-</button>
        <h6 style="color:red;padding:8px 0;">سفارش حداقل ۱ کیلو و حداکثر ۴ کیلو</h4>

        <hr />

        <div class="pill-container">
            <div style="flex:1">
                <span class="pill" style="background-color:#eee;">قیمت بازار</span>
            </div>
            <div style="flex:1;text-align:center;">
                <span>{{number_format($availableProduct->price)}} تومان</span>
            </div>
        </div>

        <div class="pill-container">
            <div style="flex:1">
                <span class="pill" style="background-color:red;color:white;">تخفیف</span>
            </div>
            <div style="flex:1;text-align:center;font-size:20px;color:red;">
                <span>{{$lastDiscount}}%</span>
            </div>
        </div>

        <div class="pill-container" style="border:1px solid #64498E;border-radius:5px;">
            <div style="flex:1">
                <span class="pill" style="background-color:#64498E;color:white;">قیمت همسودی</span>
            </div>
            <div style="flex:1;text-align:center;">
                <span style="color:#64498E;font-size:16px;">{{number_format($availableProduct->price * (100-$lastDiscount) / 100)}} تومان</span>
            </div>
        </div>

        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <a class="btn submit-order-button" href="/selectAddress">
                ثبت سفارش
            </a>
        </div>
    </div>

    <script>
        var quantity = 1;
        function add() {
            quantity = quantity > 3 ? 4 : quantity += 0.5;
            $("#quantity").text(quantity);
        }

        function subtrack() {
            quantity = quantity < 2 ? 1 : quantity -= 0.5;
            $("#quantity").text(quantity);
        }
    </script>
@endsection
