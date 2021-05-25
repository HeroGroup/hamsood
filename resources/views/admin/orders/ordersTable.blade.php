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
                <!--<th>محصولات سفارش</th>-->
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
                    <td>{{number_format($order->total_price-$order->items->sum('extra_discount'))}} تومان</td>
                    <td>{{number_format($order->discount+$order->items->sum('extra_discount'))}} تومان</td>
                    <td>{{$order->shippment_price}}</td>
                    <td>{{config('enums.payment_method.'.$order->payment_method)}}</td>
                    <!--<td>{{$order->getDetails()}}</td>-->
                    <td style="direction:ltr; text-align:center;">{{jdate('Y/m/j H:i', strtotime($order->created_at))}}</td>
                    <td>{{$order->delivery_time}} {{$order->delivery_date}}</td>
                    <td>{{$order->neighbourhood_id > 0 ? $order->neighbourhood->name . ' ' . $order->address: ''}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                عملیات
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-left" role="menu">
                            @if($order->status == 1) <!--   ثبت -->
                                <li style="padding:5px 10px;">
                                    <a href="{{ route('orders.delivered', $order->id) }}" class="btn btn-xs btn-success">تغییر وضعیت به ارسال شده</a>
                                </li>
                                <li style="padding:5px 10px;">
                                    <a href="{{ route('orders.failed', $order->id) }}" class="btn btn-xs btn-danger">لغو سفارش</a>
                                </li>
                            @elseif($order->status == 11)
                                <li style="padding:5px 10px;">
                                    <a href="{{ route('orders.delivered', $order->id) }}" class="btn btn-xs btn-success">تغییر وضعیت به ارسال شده</a>
                                </li>
                            @endif
                                <li style="padding:5px 10px;">
                                    <a href="{{route('orders.bill', $order->id)}}" class="btn btn-xs btn-info">مشاهده فاکتور</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h5 style="text-align: center">لیست خالی می باشد.</h5>
@endif
