@if($products->count() > 0)
<div class="container-fluid table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>شناسه</th>
            <th>محصول</th>
            <th>قیمت</th>
            <th>تعداد</th>
            <th>حداکثر اعضا</th>
            <th>فعال تا</th>
            <th>خریداری شده - ارسال شده</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->product->name}}</td>
                <td>{{number_format($product->price)}} تومان</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->maximum_group_members}} نفر</td>
                <td>{{config('enums.active_until.'.$product->available_until_datetime)}} {{$product->until_day}}</td>
                <!--<td style="text-align: right;">{{$product->getDiscounts()}}</td>-->
                <td style="text-align: center;font-size:18px;">
                    <span style="color:lightgreen">{{$product->getOrdersCount()}}</span> -
                    <span style="color:orange;">{{$product->getSentOrdersCount()}}</span>
                </td>
                <td>
                    <a href="{{route('orders.index', $product->id)}}" class="btn btn-xs btn-info" data-toggle="tooltip" title="لیست سفارشات">لیست سفارشات</a>
                    <a href="#" onclick="showInModal('{{$product->getDiscounts()}}')" class="btn btn-xs btn-warning" data-toggle="tooltip" title="{{$product->getDiscounts()}}">ریز تخفیفات</a>
                    @if($product->is_active)
                        <a href="{{route('availableProducts.edit', $product)}}" class="btn btn-xs btn-success" data-toggle="tooltip" title="ویرایش">ویرایش</a>
                        <a href="{{ route('availableProducts.toggleActivate', $product->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" title="غیرفعال">
                            غیرفعال
                        </a>
                    @else
                        <a href="{{ route('availableProducts.toggleActivate', $product->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="فعالسازی">
                            فعالسازی
                        </a>
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
<script>
    function showInModal(msg) {
        swal(msg);
    }
</script>
