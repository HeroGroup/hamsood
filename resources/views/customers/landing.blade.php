@extends('layouts.customer', ['pageTitle' => 'سفارش', 'withMenu' => true, 'cartItemsCount' => $cartItemsCount])
@section('content')
<style>
.text-badge {
    display:inline-block;
    width:50px;
    color:white;
    padding:2px;
    border-radius:5px;
    text-align:center;
}
.bg-red {
    background-color:red;
}
.bg-gray {
    background-color:gray;
}
.people {
    font-size:1em;
    color:#64498F;
    background-color:#DDE1FD;
    margin:0;
    padding:5px 0;
}
.people-active {
    background-color:#8A95F5;
    border-color:#8A95F5;
}
.discount {
    font-size:1em;
    color:#64498F;
    background-color:#FCE1E3;
    margin:0; padding:5px 0;

}
.discount-active {
    background-color:#FB5152;
    color:white;
}
#supporting-areas-message {
    height:50px;
    padding:20px 10px;
    background-color:rgba(0,0,0,0.6);
    z-index:11;
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

</style>
@include('layouts.bottomMenu')

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
        @foreach($result as $item)
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;">
            <div style="display:flex;flex-direction:row;padding:10px;cursor:pointer;" onclick="goToDetailPage('{{$item['product']->id}}')">
                <div style="flex:1">
                    <img src="{{$item['product']->image_url}}" style="width:100%;border:1px solid lightgray;border-radius:10px;padding:5px;" />
                </div>
                <div style="flex:2;text-align:center;">
                    <h4 style="margin-top:0;padding-top:0;">{{$item['product']->name}}</h4>
                    <div style="text-align:right;padding-left:15px;padding-right:15px;font-size:12px;">
                        <?php echo $item['product']->description ?>
                    </div>
                </div>
            </div>
            <div style="border:1px solid lightgray;border-radius:5px;margin:0 10px;">
                <div style="text-align:center;margin:10px 0">
                    <span style="color:white;background-color:#FF5A30;padding:2px 15px;border-radius:5px;">قیمت باراز {{number_format($item['availableProduct']->price)}} تومان</span>
                </div>
                @if($item['userWeight'] > 0)
                <div style="display:flex;flex-direction:row;color:gray;">
                    <div style="flex:1;border-left:1px solid lightgray;text-align:center;padding:5px;">
                        <h4>سود شما</h4>
                        <h4>تا این لحظه</h4>
                        <h4 style="color:#31AC6B;border:1px solid #31AC6B;border-radius:5px;margin:0 5px;padding:5px;">{{number_format(($item['lastDiscount'])*$item['availableProduct']->price*$item['userWeight']/100)}} تومان</h4>
                    </div>
                    <div style="flex:1;text-align:center;padding:5px;">
                        <h4>پرداختی شما</h4>
                        <h4>تا این لحظه</h4>
                        <h4 style="background-color: #2680EB;color:white;border-radius:5px;margin:0 5px;padding:5px;">
                            <?php $discount = $item['myGroupIsComplete'] ? $item['details']->max('discount') : $item['lastDiscount']; ?>
                            {{number_format((100-$discount)*$item['availableProduct']->price*$item['userWeight']/100)}} تومان
                        </h4>
                    </div>
                </div>
                @else
                <div style="display:flex;flex-direction:row;color:gray;">
                    <div style="flex:2;border-left:1px solid lightgray;text-align:center;padding:5px;">
                        <p><b>تخفیف با</b></p>
                        <div style="display:flex;">
                            <p style="flex:1;text-align:center;font-size:1em;">
                                نفر
                            </p>
                            <p style="flex:2;text-align:center;font-size:1.5em;">
                                2
                            </p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;text-align:center;font-size:0.8em;">
                                <span class="text-badge bg-red">تخفیف</span>
                            </p>
                            <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$item['details']->min('discount')}}%</b></p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;font-size:0.8em;text-align:center;">
                                <span class="text-badge bg-gray">همسودی</span>
                            </p>
                            <div style="flex:2;text-align:center;">
                                <p>{{number_format((100-$item['details']->min('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></p>
                            </div>
                        </div>
                    </div>
                    <div style="flex:2;text-align:center;padding:5px;">
                        <p><b>تخفیف با</b></p>
                        <div style="display:flex;">
                            <p style="flex:1;text-align:center;font-size:1em;">
                                نفر
                            </p>
                            <p style="flex:2;text-align:center;font-size:1.5em;">
                                {{$item['availableProduct']->maximum_group_members}}
                            </p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;text-align:center;font-size:0.8em;">
                                <span class="text-badge bg-red">تخفیف</span>
                            </p>
                            <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$item['details']->max('discount')}}%</b></p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;font-size:0.8em;text-align:center;">
                                <span class="text-badge bg-gray">همسودی</span>
                            </p>
                            <div style="flex:2;text-align:center;">
                                <p>{{number_format((100-$item['details']->max('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div style="display: flex;padding:10px;justify-content: center;align-items: flex-end;">
                <div style="flex:1;text-align: center;">
                    @if($item['userCartWeight'] > 0)
                    <div style="display:flex;">
                        <button class="add-subtract-button" style="flex:1" onclick="addWeight('{{$item['availableProduct']->id}}', 4)">+</button>
                        <span id="weight-{{$item['availableProduct']->id}}" style="flex:1;margin:0 8px;font-size:16px;">{{$item['userCartWeight']}}</span>
                        <button class="add-subtract-button" id="subtract-{{$item['availableProduct']->id}}" style="flex:1" onclick="subtractWeight('{{$item['availableProduct']->id}}')">
                            @if($item['userCartWeight'] > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                        </button>
                    </div>
                    @elseif($item['userWeight'] > 0)
                        <a class="btn" href="{{route('customers.orders.products', $item['orderId'])}}" style="border-color:#64498E;color:#64498E;width:100%;">جزيیات سفارش</a>
                    @else
                        <button class="btn hamsood-btn" style="background-color:#64498E;width:100%;color:white" onclick="goToDetailPage('{{$item['product']->id}}')">منم همسود می شوم</button>
                    @endif
                </div>
                <div style="flex:1;margin:2px 10px;">
                    <div style="display:flex;align-items:flex-end;">
                        <div style="flex:1;text-align:right;">
                            <label for="peopleBought-{{$item['availableProduct']->id}}">{{$item['peopleBought']}} نفر همسودی</label>
                        </div>
                        <div style="flex:1;text-align:left;">
                            @for($i=0;$i<$item['peopleBought'];$i++)
                                @if($i<=3)
                                <img src="/images/avatars/avatar{{rand(1,9)}}.png" width="25" height="25" style="border-radius:50%;@if($i!=$item['peopleBought']-1) margin-left:-10px; @endif" />
                                @else
                                <span style="color:#222;">.</span>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <!--<progress id="peopleBought-{{$item['availableProduct']->id}}" value="{{$item['peopleBought']}}" max="{{$item['availableProduct']->maximum_group_members}}" style="width:100%;"></progress>-->
                    <div class="progress" id="peopleBought-{{$item['availableProduct']->id}}" style="margin-bottom:0;margin-top:3px;height:12px;">
    					<div class="progress-bar" role="progressbar" aria-valuenow="{{$item['peopleBought']}}" aria-valuemin="0" aria-valuemax="{{$item['availableProduct']->maximum_group_members}}" style="width:{{$item['peopleBought']/$item['availableProduct']->maximum_group_members*100}}%"></div>
  					</div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
</div>

<script src="/js/custom.js" type="text/javascript"></script>
<script>
    window.onload = function() {
        $("#main-div").parent().css({"background-color":"#eee"});
        countdown(parseInt("{{$result[0]['remaining']}}") * 1000);
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
