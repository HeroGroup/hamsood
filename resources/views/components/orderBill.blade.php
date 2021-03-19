<style>
    .main-div {
        background-color:white;
        color:#222;
        border-radius:15px;
        display: flex;
        flex-direction: column;
        height:320px;
        overflow:hidden;
    }
    .row-item {
        flex:1;
        background-color:#ddd;
        display: flex;
        flex-direction: row;
        justify-content: space-between;align-items: center;
    }
    .price, .txt {
        flex:1;
        text-align:center;
    }
    .fs-16 {
        font-size:15px;
    }
    p {
        margin:0;
    }
</style>
<div class="main-div">
    <div class="row-item">
        <p class="txt fs-16">مجموع قیمت کالاها</p>
        <div class="price">
            <p class="fs-16"><del>{{number_format($realPrice)}} تومان</del></p>
            <p class="fs-16"><b>{{number_format($yourPrice)}} تومان</b></p>
        </div>
    </div>
    <div class="row-item" style="background-color:#eee;">
        <p class="txt fs-16">هزینه ارسال</p>
        <div class="price">
            @if(isset($shippmentPrice) && isset($shippmentPriceForNow) && $shippmentPrice != $shippmentPriceForNow)
                <p class="fs-16"><del>{{number_format($shippmentPrice) . ' تومان'}}</del></p>
                <p class="fs-16"><b>{{$shippmentPriceForNow > 0 ? $shippmentPriceForNow : 'رایگان'}}</b></p>
            @else
                <p class="fs-16">{{$shippmentPrice > 0 ? number_format($shippmentPrice) . ' تومان' : 'رایگان'}}</p>
            @endif
        </div>
    </div>
    <div class="row-item" style="color:#31AC6B;">
        <p class="txt fs-16">سود شما</p>
        <p class="price fs-16"><b>{{number_format($yourProfit)}} تومان</b></p>
    </div>
    <div class="row-item" style="background-color:#eee;">
        <h4 class="txt">مبلغ قابل پرداخت</h4>
        <h4 class="price">{{number_format($yourPayment)}} تومان</h4>
    </div>
</div>
