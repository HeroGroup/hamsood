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
    <a class="btn confirm-button" href="{{route('landing')}}">
        تائید
    </a>
</div>
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
