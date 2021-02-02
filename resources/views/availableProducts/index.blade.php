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
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="#active-pills" data-toggle="tab">فعال</a>
                </li>
                <li>
                    <a href="#inactive-pills" data-toggle="tab">غیرفعال</a>
                </li>
            </ul>

            <hr style="border-color:black;">

            <div class="tab-content">
                <div class="tab-pane fade in active show" id="active-pills">
                    @component('availableProducts.productsTable', ['products' => $active])@endcomponent
                </div>
                <div class="tab-pane fade in" id="inactive-pills">
                    @component('availableProducts.productsTable', ['products' => $inactive])@endcomponent
                </div>
            </div>

        </div>
    </div>
@endsection
