@extends('layouts.orders', ['orders' => $orders, 'selected' => $selected])
@section('tab-content')

    <div style="margin:0 10px;">
        @if($selected=='success' && $orders->count() > 0)
            <div style="border:1px solid #31AC6B;border-radius:5px;display: flex;justify-content: center;align-items: center;background-color:#eee;margin-bottom:15px;text-align:center;">
                <div style="flex:1">
                    <h4 style="color:gray;">مبلغ کل سفارشات</h4>
                    <h3 style="color:#222">{{number_format($orders->sum('total_price'))}} تومان</h3>
                </div>
                <div style="flex:1">
                    <h4 style="color:gray;">سود کل شما</h4>
                    <h3 style="color:#3ca8ff">{{number_format($orders->sum('discount'))}} تومان</h3>
                </div>
            </div>
        @endif
    @foreach($orders as $order)
        <div style="border:1px solid lightgray;border-radius:5px;color:#222;overflow:hidden;text-align: center;margin:10px 0;">
            <div class="page-heading">
                <span>شماره سفارش: {{$order->id}}</span>
                <span>{{jdate('d F Y', strtotime($order->created_at))}}</span>
            </div>
            @switch($selected)
                @case("current")
                    <h5><b>سفارش شما در مرحله تکمیل همسودی می باشد</b></h5>
                    <div style="display: flex;align-items: center;">
                        <div style="flex:1;">فرصت باقیمانده تا تکمیل همسودی ها:</div>
                        <div style="flex:1;text-align: center;color:red;direction: ltr;font-size:2rem;">
                            <span id="days">00</span>:
                            <span id="hours">00</span>:
                            <span id="minutes">00</span>:
                            <span id="seconds">00</span>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:space-around;margin-top:15px;">
                        <div style="flex:1">
                            <button class="btn" style="background-color:#64498E;color:white;" onclick="share('{{$order->uid}}')">
                                ارسال دعوت نامه
                                <i class="fa fa-fw fa-share"></i>
                            </button>
                        </div>
                        <div style="flex:1">
                            <button class="btn" style="background-color:white;color:red;border-color:red;" onclick="cancelOrder('{{route('customers.orders.cancelOrder', $order->id)}}')">لغو سفارش</button>
                        </div>

                    </div>
                    @break
                @case("success")
                    <h5>سفارش شما با موفقیت در تاریخ {{jdate('d F Y', strtotime($order->created_at))}} ارسال شد</h5>
                    @break
                @case("failed")
                    @if($order->status == 3)
                        <h5>سفارش به دلیل نرسیدن به حد نصاب لغو شد.</h5>
                    @else
                        <h5>سفارش لغو شده توسط کاربر</h5>
                    @endif
                    @break
                @default
                    @break
            @endswitch
            <hr />
            <div style="display: flex;justify-content: center;align-items: center;">
                <div style="flex:1">
                    <h4 style="color:gray;">مبلغ سفارش</h4>
                    <h3 style="color:#222">{{number_format($order->total_price)}} تومان</h3>
                </div>
                <div style="flex:1">
                    <h4 style="color:gray;">سود شما</h4>
                    <h3 style="color:#3ca8ff">{{number_format($order->discount)}} تومان</h3>
                </div>
            </div>
            <hr />
            <div style="margin-bottom:15px;text-align: center;">
                <a style="color:gray;text-decoration:none;border:1px solid lightgray;border-radius:5px;padding:2px 15px;" href="{{route('customers.orders.products', $order->id)}}">
                    <i class="fa fa-fw fa-info" style="color:gray;font-size:16px;border:1px solid lightgray;border-radius:50%;"></i>
                    <span>جزئیات</span>
                </a>
            </div>
        </div>
    @endforeach
    </div>

    <script src="/js/custom.js" type="text/javascript"></script>
    <script>
        var remaining = "{{isset($remaining) ? $remaining : 0}}";
        countdown(parseInt(remaining) * 1000);

        function cancelOrder(cancelRoute) {
          Swal.fire({
              title: 'سفارش را لغو می کنید؟',
              showCancelButton: true,
              confirmButtonColor:'#d33',
              confirmButtonText: `لغو می کنم`,
              cancelButtonText: `انصراف`,
              showCloseButton: true
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                window.location.href = cancelRoute;
              } else if (result.isDenied) {
                //
              }
            })
        }
    </script>
@endsection
