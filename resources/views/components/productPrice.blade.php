
<style>
.pill-container {
    display:flex;
    /*justify-content:space-between;*/
    margin:0 5px;
    padding:5px 0;
}
.pill {
    display:inline-block;
    width:80px;
    border-radius:5px;
    padding:5px;
    font-size:10px;
}
</style>
<div class="pill-container">
    <div style="flex:1;text-align:right;">
        <span class="pill" style="background-color:#eee;text-align:center;">قیمت بازار</span>
    </div>
    <div style="flex:1;text-align:left;">
        <span id="product-price-{{$availableProduct->id}}">{{number_format($weight * $availableProduct->price)}} </span><span style="font-size:12px;">تومان</span>
    </div>
</div>

<div class="pill-container">
    <div style="flex:1;text-align:right;">
        <span class="pill" style="background-color:red;color:white;text-align:center;">تخفیف</span>
    </div>
    <div style="flex:1;font-size:20px;color:red;text-align:left;">
        <span>{{$nextDiscount}}%</span>
    </div>
</div>

<div class="pill-container">
    <div style="flex:1;text-align:right;">
        <span class="pill" style="background-color:#64498E;color:white;text-align:center;">قیمت همسودی</span>
    </div>
    <div style="flex:1;text-align:left;">
        <span id="hamsood-price-{{$availableProduct->id}}" style="color:#64498E;font-size:16px;">{{number_format($weight * $availableProduct->price * (100-$nextDiscount) / 100)}} </span><span style="font-size:12px;">تومان</span>
    </div>
</div>
