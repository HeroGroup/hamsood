@extends('layouts.admin', ['pageTitle' => $title, 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            سفارشات
            <button class="btn btn-xs btn-success" style="float: left;" onclick="createPDF('table-data')"><i class="fa fa-fw fa-file-pdf-o" style="color:red;"></i> خروجی PDF</button>
        </div>
        <div class="panel-body">
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'active-pills')">ثبت شده</button>
                <button class="tablinks" onclick="openTab(event, 'paid-pills')">پرداخت شده</button>
                <button class="tablinks" onclick="openTab(event, 'sent-pills')">ارسال شده</button>
                <button class="tablinks" onclick="openTab(event, 'canceled-pills')">لغو توسط کاربر</button>
                <button class="tablinks" onclick="openTab(event, 'failed-pills')">لغو به دلیل نرسیدن به حد نصاب</button>
            </div>

            <hr style="border-color:#666;" />

            <div id="active-pills" class="tabcontent" style="display: block;">
                @component('orders.ordersTable', ['orders' => $active])@endcomponent
            </div>
            <div id="paid-pills" class="tabcontent" style="display: block;">
                @component('orders.ordersTable', ['orders' => $paid])@endcomponent
            </div>
            <div id="sent-pills" class="tabcontent">
                @component('orders.ordersTable', ['orders' => $sent])@endcomponent
            </div>
            <div id="canceled-pills" class="tabcontent">
                @component('orders.ordersTable', ['orders' => $canceled])@endcomponent
            </div>
            <div id="failed-pills" class="tabcontent">
                @component('orders.ordersTable', ['orders' => $failed])@endcomponent
            </div>
        </div>
    </div>
@endsection
