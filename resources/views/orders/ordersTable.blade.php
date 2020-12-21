@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>شماره موبایل مشتری</th>
                <th>مجموع قیمت سفرش</th>
                <th>درصد تخفیف</th>
                <th>محصولات سفارش</th>
                <th>شناسه گروه</th>
                <th>زمان</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->customer->mobile}}</td>
                    <td>{{number_format($order->total_price)}} تومان</td>
                    <td>{{$order->discount}}%</td>
                    <td>{{$order->getDetails()}}</td>
                    <td style="color:lightblue;">{{$order->getItemsIds()}}</td>
                    <td style="direction:ltr; text-align:center;">{{jdate('Y/m/j H:i', strtotime($order->created_at))}}</td>
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
