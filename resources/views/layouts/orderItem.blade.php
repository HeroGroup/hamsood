@extends('layouts.customer', ['pageTitle' => 'جزئیات سفارش', 'withNavigation' => true])
@section('content')
<style>
    .main-container {
        margin: 80px 10px;
        border:1px solid lightgray;
        border-radius:5px;
        color:#222;
    }
    .page-heading {
        background-color:#eee;
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:10px;
    }
    .tab-container {
        background-color:#eee;
        border-radius:5px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin:20px 10px;
    }
    .tab-item {
        flex:1;
        text-align:center;
        color:#222;
        border:none;
        padding:5px 0;
    }
    .tab-item:hover {
        text-decoration:none;
        color:#333;
    }
    .selected {
        border:1px solid green;
        border-radius:5px;
        background-color:white;
    }
</style>
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
