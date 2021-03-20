@extends('layouts.customer', ['pageTitle' => 'جزئیات سفارش', 'withNavigation' => true])
@section('content')
<div class="main-container">
    <div class="page-heading">
        <span>شماره سفارش: {{$order->id}}</span>
        <span>{{jdate('d F Y', strtotime($order->created_at))}}</span>
    </div>
    <div class="tab-container">
        <a href="{{route('customers.orders.products', $order->id)}}" id="products" class="tab-item @if($selected == 'products') selected @endif">کالاها</a>
        <a href="{{route('customers.orders.address', $order->id)}}" id="address" class="tab-item @if($selected == 'address') selected @endif">آدرس</a>
        <a href="{{route('customers.orders.bill', $order->id)}}" id="bill" class="tab-item @if($selected == 'bill') selected @endif">صورتحساب</a>
    </div>

    @yield('tab-content')

</div>
<div style="position:fixed;bottom:0;left:0;width:100%;">
    <button onclick="share('{{$order->uid}}')" class="btn" style="color:#64498E;border:none;border-top:1px solid #64498E;background-color:white;width:100%;border-radius:0;padding:15px 0;font-size:20px;">
        ارسال دعوت نامه
        <i class="fa fa-fw fa-share"></i>
    </button>
</div>

<script src="/js/custom.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".tab-item").on("click", function() {
        event.preventDefault();
        // document.getElementsByClassnames("selected").classList.remove("selected");
        $(".selected").removeClass("selected");
        $(this).addClass("selected");

        // console.log($(this).attr("href"));

        window.location.href = $(this).attr("href");
    });
</script>

@endsection
