<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>همسود | پیشنهاد</title>
        <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
        <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
        <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/css/my.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
        <script src="/js/sweetalert2.min.js" type="text/javascript"></script>
    </head>
    <body style="background-color:#f1f1f1;color:#222;">
        <div class="top-navigation" style="display:flex;justify-content:space-between;align-items:center;z-index:4;">
            <a href="/">
                <img src="/images/home_icon.png" width="45" height="45" />
            </a>
            <h4 style="color:#222;">پیشنهاد</h4>
            <a href="{{route('customers.customerCart')}}" style="cursor:pointer;float:left;position:relative;width:60px;text-align:center;">
                @if(isset($cartItemsCount) && $cartItemsCount>0)
                    <div style="background-color:#31AC6B;border-radius:50%;color:white;width:20px;text-align:center;position:absolute;top:0;right:0;">{{$cartItemsCount}}</div>
                @endif
                <img src="/images/basket_icon.png" width="40" height="40" />
            </a>
        </div>
        <div style="margin:65px 10px;background-color:white;border-radius:5px;padding:5px;">
            <div style="border:1px solid lightgray;border-radius:5px;padding:5px;display:flex;align-items:center;font-size:16px;">
                <div style="flex:2;display:flex;">
                    <div>
                        <img src="/images/avatars/male4.png" width="40" height="40" />
                    </div>
                    <div>
                        <div>{{$order->customer->name}}</div>
                        <div style="font-size:12px;">تاریخ عضویت {{jdate('Y/m/j', strtotime($order->customer->created_at))}}</div>
                        <div>
                            <img src="/images/location_icon.png" width="14" height="14" />
                            <span>{{$order->neighbourhood->name}}</span>
                        </div>
                    </div>
                </div>
                <div style="flex:1;border:1px solid lightgray;border-radius:5px;padding:5px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="text-align:center;">
                        <div style="font-size:12px;">زمان باقیمانده</div>
                        <div style="color:red;font-size:12px;">
                            <span id="seconds">00</span>
                            <span id="minutes">00</span>
                            <span id="hours">00</span>
                            <span id="days">00</span>
                        </div>
                    </div>
                    <img src="/images/wire_clock_icon.png" width="30" height="30" />
                </div>
            </div>

            <hr />
            <?php $iterator = 0; ?>
            @foreach($items as $item)
                <?php $iterator++; ?>
                <h4 style="text-align:center;">{{$item['availableProduct']->product->name}}</h4>
                <div style="display:flex;align-items:center;">
                    <div style="flex:1;">
                        <label>{{$iterator}}</label>
                        <img src="{{$item['availableProduct']->product->image_url}}" style="border:1px solid lightgray;border-radius:5px;width:90%;" />
                    </div>
                    <div style="flex:2;">
                        @component('components.productPrice', ['availableProduct' => $item['availableProduct'], 'nextDiscount' => $item['nextDiscount']])@endcomponent
                    </div>
                </div>
                <div style="display: flex;padding:10px;justify-content: center;align-items: flex-end;">
                    <div style="flex:1;text-align: right;">
                        @if($item['userCartWeight'] > 0)
                            <button class="add-subtract-button" onclick="addWeight('{{$item['availableProduct']->id}}', 4)">+</button>
                            <span id="weight-{{$item['availableProduct']->id}}" style="margin:0 8px;font-size:16px;">{{$item['userCartWeight']}}</span>
                            <button class="add-subtract-button" id="subtract-{{$item['availableProduct']->id}}" onclick="subtractWeight('{{$item['availableProduct']->id}}')">
                                @if($item['userCartWeight'] > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                            </button>
                        @elseif($item['userWeight'] > 0)
                            <a class="btn" href="{{route('customers.orders.products', $item['orderId'])}}" style="border-color:#64498E;color:#64498E;width:100%;">جزيیات سفارش</a>
                        @else
                            <a class="btn hamsood-btn" href="{{route('customers.addToCart', ['product' => $item['product']->id, 'return' => true])}}" style="background-color:#31AC6B;width:100%;color:white">افزودن به سبد</a>
                        @endif
                    </div>
                    <div style="flex:1;text-align:center;">
                        <div style="display:flex;">
                            <div style="flex:1">
                                <label for="peopleBought-{{$item['availableProduct']->id}}">{{$item['peopleBought']}} نفر همسودی</label>
                            </div>
                            <div style="flex:1">
                                <img src="/images/group_icon.png" width="80" height="35" />
                            </div>
                        </div>
                        <progress id="peopleBought-{{$item['availableProduct']->id}}" value="{{$item['peopleBought']}}" max="{{$item['availableProduct']->maximum_group_members}}" style="width:90%;"></progress>
                    </div>
                </div>
            @endforeach
        </div>

        <script src="/js/custom.js" type="text/javascript"></script>
        <script>
            window.onload = function() {
                countdown(parseInt("{{$items[0]['remaining']}}") * 1000);
            };
        </script>
    </body>
</html>
