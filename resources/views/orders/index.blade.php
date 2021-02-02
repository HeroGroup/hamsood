@extends('layouts.admin', ['pageTitle' => 'سفارشات ' . (isset($availableProduct) ? "گروه #$availableProduct ($productName)" : ''), 'newButton' => false])
@section('content')
    <style>
        .nav > li > a {
            /*padding:5px 25px;*/
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">سفارشات</div>
        <div class="panel-body">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="#active-pills" data-toggle="tab">ثبت شده</a>
                </li>
                <li>
                    <a href="#inactive-pills" data-toggle="tab">ارسال شده</a>
                </li>
            </ul>

            <hr style="border-color:black;">

            <div class="tab-content">
                <div class="tab-pane fade in active show" id="active-pills">
                    @component('orders.ordersTable', ['orders' => $active])@endcomponent
                </div>
                <div class="tab-pane fade in" id="inactive-pills">
                    @component('orders.ordersTable', ['orders' => $inactive])@endcomponent
                </div>
            </div>

        </div>
    </div>
@endsection
