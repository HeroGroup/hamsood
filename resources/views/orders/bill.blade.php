@extends('layouts.admin', ['pageTitle' => "فاکتور سفارش $order->id", 'newButton' => false])
@section('content')
<div class="col-lg-4">
    <div style="display:flex">
        <h4 style="flex:1;text-align:right;">نام مشتری: {{$order->customer->name}}</h4>
        <h4 style="flex:1;text-align:left;">{{jdate('Y/m/j', strtotime($order->created_at))}}</h4>
    </div>
    <div>
        <h5>آدرس تحویل: {{$order->address}}</h5>
    </div>
    <div>
        <h5>زمان تحویل: {{$order->delivery_date}} ساعت {{$order->delivery_time}}</h5>
    </div>
    <div>
        <h5>روش پرداخت: {{config('enums.payment_method.'.$order->payment_method)}}</h5>
    </div>
    <hr style="border-color:gray;" />
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عنوان</th>
                <th>وزن</th>
                <th>فی</th>
                <th>قیمت</th>
            </tr>
        </thead>
        <tbody>
            <?php $iterator=0; ?>
            @foreach($order->items as $item)
                <?php $iterator++; ?>
                <tr>
                    <td>{{$iterator}}</td>
                    <td>{{$item->availableProduct->product->name}}</td>
                    <td>{{$item->weight}} کیلو</td>
                    <td>{{number_format($item->availableProduct->price)}} تومان</td>
                    <td>{{number_format($item->weight*$item->availableProduct->price)}} تومان</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="4" style="text-align:center;">جمع</td>
                    <td>{{number_format($order->total_price+$order->discount)}} تومان</td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="4">تخفیف</td>
                    <td>{{number_format($order->discount)}} تومان</td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="4">هزینه ارسال</td>
                    <td>{{$order->shippment_price > 0 ? number_format($order->shippment_price) .  ' تومان' : 'رایگان'}}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center;">قابل پرداخت</td>
                    <td>{{number_format($order->total_price+$order->shippment_price)}} تومان</td>
                </tr>
        </tbody>
    </table>
</div>
@endsection
