<style>
.pill-container {
    display:flex;
    /*justify-content:space-between;*/
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
</style>
<div class="pill-container">
    <div style="flex:1;">
        <span class="pill" style="background-color:#eee;">قیمت بازار</span>
    </div>
    <div style="flex:1;">
        <span>{{number_format($availableProduct->price)}} تومان</span>
    </div>
</div>

<div class="pill-container">
    <div style="flex:1;">
        <span class="pill" style="background-color:red;color:white;">تخفیف</span>
    </div>
    <div style="flex:1;text-align:center;font-size:20px;color:red;">
        <span>{{$nextDiscount}}%</span>
    </div>
</div>

<div class="pill-container" style="border:1px solid #64498E;border-radius:5px;">
    <div style="flex:1;">
        <span class="pill" style="background-color:#64498E;color:white;">قیمت همسودی</span>
    </div>
    <div style="flex:1;text-align:center;">
        <span style="color:#64498E;font-size:16px;">{{number_format($availableProduct->price * (100-$nextDiscount) / 100)}} تومان</span>
    </div>
</div>
