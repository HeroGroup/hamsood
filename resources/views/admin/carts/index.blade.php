@extends('layouts.admin', ['pageTitle' => 'سبد خرید های فعال', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">سبد خرید های فعال</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>مشتری</th>
                        <th>لیست خرید</th>
                        <th>تاریخ ثبت</th>
                        <th>عملیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $cart)
                        <tr>
                            <td>{{$cart->customer->name. ' - '.$cart->customer->mobile}}</td>
                            <td>{{$cart->customer->getCartList()}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime(\App\CustomerCartItem::where('customer_id', $cart->customer_id)->first()->created_at))}}</td>
                            <td>
                                <a class="btn btn-xs btn-danger" href="{{route('carts.destroy',$cart->customer_id)}}">حذف</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
