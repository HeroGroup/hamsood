@extends('layouts.admin', ['pageTitle' => 'گروه محصولات موجود', 'newButton' => true, 'newButtonUrl' => 'availableProducts/create', 'newButtonText' => 'ایجاد گروه محصول'])
@section('content')
    <style>
        .nav > li > a {
            /*padding:5px 25px;*/
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">گروه های محصولات</div>
        <div class="panel-body">
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'active-pills')">فعال</button>
                <button class="tablinks" onclick="openTab(event, 'inactive-pills')">غیرفعال</button>
            </div>

            <hr style="border-color:#666;" />

            <div id="active-pills" class="tabcontent" style="display: block;">
                @component('availableProducts.productsTable', ['products' => $active])@endcomponent
            </div>
            <div id="inactive-pills" class="tabcontent">
                @component('availableProducts.productsTable', ['products' => $inactive])@endcomponent
            </div>

        </div>
    </div>
@endsection
