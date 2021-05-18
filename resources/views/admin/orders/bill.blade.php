@extends('layouts.admin', ['pageTitle' => "فاکتور سفارش $order->id", 'newButton' => false])
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div style="display:flex">
            <h4 style="flex:1;text-align:right;">نام مشتری: {{$order->customer->name}}</h4>
            <h4 style="flex:1;text-align:left;">{{jdate('Y/m/j', strtotime($order->created_at))}}</h4>
        </div>
        <p>آدرس تحویل: {{$order->neighbourhood->name}} - {{$order->address}}</p>
        <p>زمان تحویل: {{$order->delivery_date}} ساعت {{$order->delivery_time}}</p>
        <p>روش پرداخت: {{config('enums.payment_method.'.$order->payment_method)}}</p>

        <hr style="border-color:gray;" />
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>عنوان</th>
                <th>وزن</th>
                <th>فی</th>
                <th>قیمت</th>
                <th>تعداد همسود</th>
                <th>درصد تخفیف</th>
                <th>قیمت بعد از تخفیف</th>
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
                    <td>{{number_format($item->real_price)}} تومان</td>
                    <td>{{number_format($item->weight*$item->real_price)}} تومان</td>
                    <td style="text-align:center">{{\App\OrderItem::where('available_product_id',$item->available_product_id)->max('nth_buyer')}}</td>
                    <td style="text-align:center">{{($item->weight * $item->discount + $item->extra_discount) / ($item->weight * $item->real_price) * 100}}%</td>
                    <td>{{number_format($item->weight*$item->real_price-$item->weight*$item->discount-$item->extra_discount)}} تومان</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="text-align:center;">قیمت بازار</td>
                    <td>{{number_format($order->total_price+$order->discount)}} تومان</td>
                </tr>
                <tr>
                    <td style="text-align:center;">سود شما</td>
                    <td>{{number_format($order->discount+$order->items()->sum('extra_discount'))}} تومان</td>
                </tr>
                <tr>
                    <td style="text-align:center;">هزینه ارسال</td>
                    <td>{{$order->shippment_price > 0 ? number_format($order->shippment_price) .  ' تومان' : 'رایگان'}}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">قابل پرداخت</td>
                    <td>{{number_format($order->total_price+$order->shippment_price-$order->items()->sum('extra_discount'))}} تومان</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
