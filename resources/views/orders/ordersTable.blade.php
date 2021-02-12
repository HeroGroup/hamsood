@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>مشتری</th>
                <th>پرداختی مشتری</th>
                <th>تخفیف</th>
                <th>هزینه ارسال</th>
                <!-- <th>محصولات سفارش</th> -->
                <th>شناسه گروه</th>
                <th>زمان ثبت سفارش</th>
                <th>زمان تحویل</th>
                <th>آدرس</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->customer_name}} {{$order->customer->mobile}}</td>
                    <td>{{number_format($order->total_price)}} تومان</td>
                    <td>{{number_format($order->discount)}} تومان</td>
                    <td>{{$order->shippment_price}}</td>
                    <!-- <td>{{$order->getDetails()}}</td> -->
                    <td style="color:lightblue;">{{$order->getItemsIds()}}</td>
                    <td style="direction:ltr; text-align:center;">{{jdate('Y/m/j H:i', strtotime($order->created_at))}}</td>
                    <td>{{$order->delivery_time}} {{$order->delivery_date}}</td>
                    <td>{{$order->address}}</td>
                    <td>
                        @if($order->status == 1) <!--   ثبت -->
                            <a href="{{ route('orders.delivered', $order) }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="تغییر وضعیت به ارسال شده">
                                تغییر وضعیت به ارسال شده
                            </a>
                        @else <!--   ارسال شده -->
                            <div class="label label-info">ارسال شده</div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h5 style="text-align: center">لیست خالی می باشد.</h5>
@endif
