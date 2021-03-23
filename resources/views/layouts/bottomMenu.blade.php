<style>
    .bottom-menu {
        overflow: hidden;
        background-color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
        display:flex;
        justify-content:space-between;
    }

    .bottom-menu a {
        flex:1;
        /*float: left;*/
        /*display: block;*/
        color: #222;
        text-align: center;
        padding: 4px 6px;
        text-decoration: none;
        font-size: 12px;
    }

    .bottom-menu a span {
        margin-top:3px;
    }

    .bottom-menu a:hover {
        background: #ddd;
        color: black;
    }
</style>
<div class="bottom-menu">
    <a href="{{route('customers.orders.current')}}">
        <div><img src="/images/orders_icon.png" width="35" height="35" /></div>
        <span>سفارش ها</span>
    </a>
    <a href="{{route('customers.customerCart')}}">
        <div style="position:relative;text-align:center;">
            @if(isset($cartItemsCount) && $cartItemsCount>0)
                <div style="background-color:#31AC6B;border-radius:50%;color:white;width:22px;font-size:16px;text-align:center;position:absolute;top:0;right:22px;">{{$cartItemsCount}}</div>
            @endif
            <img src="/images/basket_icon.png" width="35" height="35" />
        </div>
        <span>سبد خرید</span>
    </a>
    <a href="{{route('customers.profile')}}">
        <div><img src="/images/profile_icon.png" width="26" height="26" style="margin:3px;" /></div>
        <span>پروفایل</span>
    </a>
</div>
