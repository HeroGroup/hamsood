@extends('layouts.customer', ['pageTitle' => 'سفارش', 'withMenu' => true, 'cartItemsCount' => $cartItemsCount])
@section('content')

<style>
    #supporting-areas-message {
        height:50px;
        padding:20px 10px;
        background-color:rgba(0,0,0,0.6);
        z-index:2;
        position:fixed;
        top:60px;
        left:15px;
        right:15px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-radius:10px;
    }

    #supporting-areas-message > a {
        color:white;
        text-decoration: none;
    }

    .product-item {
        background-color:white;
        border-radius:10px;
        box-shadow: 0 0 5px #888888;
        display: inline-block;
        width:200px;
        height:340px;
        cursor:pointer;
        text-align:center;
        padding:10px;
        margin-left:15px;
    }

    #addToHomeScreen {
        height:60px;
        padding:20px 10px;
        background-color:white;
        z-index:5;
        position:fixed;
        bottom:0;
        left:0;
        right:0;
        display:none;
        justify-content:space-between;
        align-items:center;
        transition: display 1s;
    }
</style>

@include('layouts.bottomMenu')

<section id="addToHomeScreen" class="banner">
    <a href="javascript:void(0)" class="install-button">
        <img src="/images/logo.png" alt="همسود" width="35" height="35">
        <span style="color:#222;">اضافه کردن <b style="color:#64498E;">همسود</b> به لیست اپلیکیشن ها</span>
    </a>
    <a href="javascript:void(0)" onclick="hidePrompt()" style="font-size:30px;color:#222;">&times;</a>
</section>

<div id="supporting-areas-message">
    <a href="{{route('supportingAreas')}}">مشاهده مناطق تحت پوشش</a>
    <a href="#" onclick="hideSupportingAreaMessage()" style="font-size:30px;">&times;</a>
</div>

<div id="main-div" style="margin:120px 0 70px 0;background-color:#eee;color:#222;">
    <div class="container">
        <div style="margin-bottom:10px;display:flex;justify-content:center;align-items:center;background-color:#FAC850;color:#444;border-radius:10px;box-shadow: 0 0 5px #888888;">
            <div class="clock-container">
                <span id="seconds" class="time-item">-</span>
                <span id="minutes" class="time-item">-</span>
                <span id="hours" class="time-item">-</span>
                <span id="days" class="time-item">-</span>
            </div>
            <div style="flex:1;text-align:center;font-size:1em;margin-top:10px;">
                <img src="/images/clock_icon.png" width="40" height="40" />
                <p>زمان باقیمانده</p>
            </div>
        </div>
        @foreach($result as $key=>$items)
        <div style="margin-bottom:15px;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;">
                <h3 style="margin:0;">{{\App\Category::find($key)->title}}</h3>
                <a href="{{route('categoryLanding',$key)}}">مشاهده همه <i class="fa fa-angle-left"></i> </a>
            </div>
            <div style="overflow:auto;white-space:nowrap;padding:5px;">
            @foreach($items as $item)
                <div class="product-item">
                    <div onclick="goToDetailPage('{{$item['product']->id}}')">
                        <img src="{{$item['product']->image_url}}" width="100" height="100" style="border:1px solid lightgray;border-radius:10px;padding:5px;" />
                        <h3 style="margin-top:10px;padding-top:0;">{{$item['product']->name}}</h3>
                        <h5 style="color:white;background-color:#FF5A30;padding:2px 15px;border-radius:5px;">قیمت بازار {{number_format($item['availableProduct']->price)}} تومان</h5>
                        @if($item['userWeight'] > 0)
                            <div style="display: flex;justify-content: space-between;padding:8px 0;">
                                <span>سود شما</span>
                                <h4 style="color:#31AC6B;border:1px solid #31AC6B;border-radius:5px;padding:0 5px;margin:0;width:100px;">{{number_format(($item['lastDiscount'])*$item['availableProduct']->price*$item['userWeight']/100)}} تومان</h4>
                            </div>
                            <div style="display: flex;justify-content: space-between;padding:8px 0;">
                                <span>پرداختی شما</span>
                                <h4 style="background-color: #2680EB;color:white;border-radius:5px;padding:0 5px;margin:0;width:100px;">
                                    <?php $discount = $item['myGroupIsComplete'] ? $item['details']->max('discount') : $item['lastDiscount']; ?>
                                    {{number_format((100-$discount)*$item['availableProduct']->price*$item['userWeight']/100)}} تومان
                                </h4>
                            </div>
                        @else
                            <div style="background-color:lightgray;display:flex;justify-content:space-between;align-items:center;border-radius:5px;">
                                <span style="background-color:gray;font-size:12px;border-radius:5px;padding:5px;color:white;">همسودی ۲</span>
                                <label style="color:white;background-color:red;border-radius:50%;width:30px;">{{$item['details']->min('discount')}}%</label>
                                <span style="padding:5px;">{{number_format((100-$item['details']->min('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></span>
                            </div>

                            <div style="background-color:lightgray;display:flex;justify-content:space-between;align-items:center;border-radius:5px;margin-top:5px;">
                                <span style="background-color:gray;color:white;font-size:12px;border-radius:5px;padding:5px;">همسودی {{$item['availableProduct']->maximum_group_members}}</span>
                                <span style="color:white;background-color:red;width:30px;border-radius:50%;">{{$item['details']->max('discount')}}%</span>
                                <span style="padding:5px;">{{number_format((100-$item['details']->max('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></span>
                            </div>
                        @endif
                        <div style="display:flex;align-items:flex-end;">
                            <div style="flex:1;text-align:right;">
                                <label for="peopleBought-{{$item['availableProduct']->id}}">{{$item['peopleBought']}} نفر </label>
                            </div>
                            <div style="flex:1;text-align:left;">
                                @for($i=0;$i<$item['peopleBought'];$i++)
                                    @if($i<=4)
                                    <img src="/images/avatars/avatar{{rand(1,49)}}.png" width="20" height="20" style="border-radius:50%;@if($i!=$item['peopleBought']-1) margin-left:-10px; @endif" />
                                    @else
                                    <span style="color:#222;">.</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="progress" id="peopleBought-{{$item['availableProduct']->id}}" style="margin-bottom:0;margin-top:3px;height:6px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$item['peopleBought']}}" aria-valuemin="0" aria-valuemax="{{$item['availableProduct']->maximum_group_members}}" style="width:{{$item['peopleBought']/$item['availableProduct']->maximum_group_members*100}}%"></div>
                        </div>
                    </div>
                    <div style="margin-top:10px;">
                        @if($item['userCartWeight'] > 0)
                            <div style="display:flex;">
                                <button class="add-subtract-button" style="flex:1" onclick="addWeight('{{$item['availableProduct']->id}}-{{$key}}', 4)">+</button>
                                <span id="weight-{{$item['availableProduct']->id}}-{{$key}}" style="flex:1;margin:0 8px;font-size:16px;">{{$item['userCartWeight']}}</span>
                                <button class="add-subtract-button" id="subtract-{{$item['availableProduct']->id}}-{{$key}}" style="flex:1" onclick="subtractWeight('{{$item['availableProduct']->id}}-{{$key}}')">
                                    @if($item['userCartWeight'] > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                                </button>
                            </div>
                        @elseif($item['userWeight'] > 0)
                            <a class="btn" href="{{route('customers.orders.products', $item['orderId'])}}" style="border-color:#64498E;color:#64498E;width:100%;">جزيیات سفارش</a>
                        @else
                            <div>
                                <button class="btn hamsood-btn" style="background-color:#64498E;width:100%;color:white" onclick="goToDetailPage('{{$item['product']->id}}')">منم همسود می شوم</button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="/js/main2.js" type="text/javascript"></script>
<script src="/js/custom.js" type="text/javascript"></script>
<script>
    window.onload = function() {
        $("#main-div").parent().css({"background-color":"#eee"});
        countdown(parseInt("{{$remaining}}") * 1000);
    };

    function goToDetailPage(product) {
        window.location.href = `/product/${product}`;
    }

    function hideSupportingAreaMessage() {
        $('#supporting-areas-message').css({'display':'none'});
        $('#main-div').css({'margin-top':'70px'});
    }
</script>
@endsection

