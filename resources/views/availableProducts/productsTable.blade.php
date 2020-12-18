@if($products->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>محصول</th>
            <th>قیمت</th>
            <th>تعداد</th>
            <th>حداکثر تعداد اعضا</th>
            <th>فعال تا</th>
            <th>میزان تخفیفات</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->product->name}}</td>
                <td>{{$product->price}} تومان</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->maximum_group_members}} نفر</td>
                <td>{{config('enums.active_until.'.$product->available_until_datetime)}}</td>
                <td style="text-align: right;">{{$product->getDiscounts()}}</td>
                <td>
                    @if($product->is_active)
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
