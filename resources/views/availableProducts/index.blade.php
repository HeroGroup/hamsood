@extends('layouts.admin', ['pageTitle' => 'گروه محصولات موجود', 'newButton' => true, 'newButtonUrl' => 'availableProducts/create', 'newButtonText' => 'ایجاد گروه محصول'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">گروه های فعال محصولات</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>محصول</th>
                        <th>قیمت</th>
                        <th>تعداد</th>
                        <th>حداکثر تعداد اعضا</th>
                        <th>فعال تا</th>
                        <th>میزان تخفیفات</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->product->name}}</td>
                            <td>{{$product->price}} تومان</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->maximum_group_members}} نفر</td>
                            <td>{{config('enums.active_until.'.$product->available_until_datetime)}}</td>
                            <td style="text-align: right;">{{$product->getDiscounts()}}</td>
                            <td>
                                <a href="{{ route('availableProducts.inactive', $product->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" title="غیرفعال">
                                    غیرفعال
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
