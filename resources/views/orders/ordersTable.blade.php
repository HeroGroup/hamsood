@if($orders->count() > 0)
    <div class="container-fluid table-responsive">
        <table id="table-data" class="table table-bordered data-table">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>مشتری</th>
                <th>پرداختی مشتری</th>
                <th>تخفیف</th>
                <th>هزینه ارسال</th>
                <th>نحوه پرداخت</th>
                <th>محصولات سفارش</th>
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
                    <td>{{$order->id}}</td>
                    <td>{{$order->customer_name}} {{$order->customer->mobile}}</td>
                    <td>{{number_format($order->total_price)}} تومان</td>
                    <td>{{number_format($order->discount)}} تومان</td>
                    <td>{{$order->shippment_price}}</td>
                    <td>{{config('enums.payment_method.'.$order->payment_method)}}</td>
                    <td>{{$order->getDetails()}}</td>
                    <td style="color:lightblue;">{{$order->getItemsIds()}}</td>
                    <td style="direction:ltr; text-align:center;">{{jdate('Y/m/j H:i', strtotime($order->created_at))}}</td>
                    <td>{{$order->delivery_time}} {{$order->delivery_date}}</td>
                    <td>{{$order->neighbourhood_id > 0 ? $order->neighbourhood->name . ' ' . $order->address: ''}}</td>
                    <td>
                        @if($order->status == 1) <!--   ثبت -->
                            <a href="{{ route('orders.delivered', $order->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="ارسال شد">
                                تغییر وضعیت به ارسال شده
                            </a>
                            <a href="{{ route('orders.failed', $order->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" title="لغو سفارش">
                                لغو سفارش
                            </a>
                        @elseif($order->status == 2) <!--   ارسال شده -->
                            <div class="label label-info">ارسال شده</div>
                        @elseif($order->status == 3) <!--   لفو شده به دلیل حد نصاب -->
                            <div class="label label-danger">لفو شده به دلیل حد نصاب</div>
                        @elseif($order->status == 4) <!--   لغو شده توسط کاربر -->
                            <div class="label label-danger">لغو شده توسط کاربر</div>
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
