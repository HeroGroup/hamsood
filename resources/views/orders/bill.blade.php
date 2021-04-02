@extends('layouts.admin', ['pageTitle' => "فاکتور سفارش $order->id", 'newButton' => false])
@section('content')
<div class="col-lg-4">
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
