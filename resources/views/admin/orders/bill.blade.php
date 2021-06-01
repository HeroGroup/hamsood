@extends('layouts.admin', ['pageTitle' => "فاکتور سفارش $order->id", 'newButton' => false])
@section('content')
    <style>
        th {
            text-align:center;
        }
    </style>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="display:flex">
                                <div>
                                    <h4 style="flex:1;text-align:right;">نام مشتری: {{$order->customer->name}}</h4>
                                    <div class="help-block">شماره تماس: {{$order->customer->mobile}}</div>
                                </div>
                                <h4 style="flex:1;text-align:left;">{{jdate('Y/m/j', strtotime($order->created_at))}}</h4>
                            </div>
                            <hr style="border-color:gray;margin-top:0;" />
                            <p style="color:lightseagreen;">آدرس تحویل: {{$order->neighbourhood->name}} - {{$order->address}}</p>
                            <p style="color:lightgreen;">زمان تحویل: {{$order->delivery_date}} ساعت {{$order->delivery_time}}</p>
                            <div class="label label-danger" style="font-size:14px;">{{config('enums.payment_method.'.$order->payment_method)}}</div>
                            @if(strlen($order->extra_description) > 0)
                                <p style="color:lightsalmon;margin-top:10px;">توضیحات: {{$order->extra_description}}</p>
                            @endif

                            <hr style="border-color:gray;" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>عنوان</th>
                                    <th>وزن (کیلو)</th>
                                    <th>فی (تومان)</th>
                                    <th>قیمت (تومان)</th>
                                    <th>تعداد همسود</th>
                                    <th>درصد تخفیف</th>
                                    <th>قیمت بعد از تخفیف (تومان)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $iterator=0; ?>
                                @foreach($order->items as $item)
                                    <?php $iterator++; ?>
                                    <tr>
                                        <td style="text-align: center;">{{$iterator}}</td>
                                        <td>{{$item->availableProduct->product->name}}</td>
                                        <td style="text-align: center;">{{$item->weight}}</td>
                                        <td>{{number_format($item->real_price)}}</td>
                                        <td>{{number_format($item->weight*$item->real_price)}}</td>
                                        <td style="text-align:center">{{\App\OrderItem::where('available_product_id',$item->available_product_id)->max('nth_buyer')}}</td>
                                        <td style="text-align:center">{{($item->weight * $item->discount + $item->extra_discount) / ($item->weight * $item->real_price) * 100}}%</td>
                                        <td>{{number_format($item->weight*$item->real_price-$item->weight*$item->discount-$item->extra_discount)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody style="text-align: center;">
                                    <tr>
                                        <td>قیمت بازار</td>
                                        <td>{{number_format($order->total_price+$order->discount)}} تومان</td>
                                    </tr>
                                    <tr>
                                        <td>سود شما</td>
                                        <td>{{number_format($order->discount+$order->items()->sum('extra_discount'))}} تومان</td>
                                    </tr>
                                    <tr>
                                        <td>هزینه ارسال</td>
                                        <td>{{$order->shippment_price > 0 ? number_format($order->shippment_price) .  ' تومان' : 'رایگان'}}</td>
                                    </tr>
                                    <tr>
                                        <td>قابل پرداخت</td>
                                        <td>{{number_format($order->total_price+$order->shippment_price-$order->items()->sum('extra_discount'))}} تومان</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
