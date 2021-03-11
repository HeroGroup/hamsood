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
</style>
@include('layouts.bottomMenu')
<div id="main-div" style="margin-top:70px;margin-bottom:70px;background-color:#eee;color:#222;">
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
            <p style="color:gray;text-align: center;">قیمت باراز {{number_format($item['availableProduct']->price)}} تومان</p>
            <div style="display:flex;flex-direction:row;color:gray;">
                <div style="flex:2;border-left:1px solid lightgray;text-align:center;padding:5px;">
                    <p><b>۲ نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$item['details']->min('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$item['details']->min('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
                <div style="flex:2;text-align:center;padding:5px;">
                    <p><b>{{$item['availableProduct']->maximum_group_members}} نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$item['details']->max('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$item['details']->max('discount'))/100*$item['availableProduct']->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex;padding:10px;justify-content: center;align-items: center;">
                <div style="flex:1;text-align: center;">
                    @if($item['userWeight'] > 0)
                        <button style="border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;font-size:20px;font-weight:bold;width:40px;border-radius:5px;" onclick="addWeight('{{$item['availableProduct']->id}}', 4)">+</button>
                        <span id="weight-{{$item['availableProduct']->id}}" style="margin:0 15px;font-size:20px;">1</span>
                        <button id="subtract-{{$item['availableProduct']->id}}" style="border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;font-size:20px;font-weight:bold;width:40px;border-radius:5px;" onclick="subtractWeight('{{$item['availableProduct']->id}}')">-</button>
                    @else
                        <button class="btn hamsood-btn" style="background-color:#64498E;width:100%;color:white" onclick="goToDetailPage('{{$item['product']->id}}')">منم همسود می شوم</button>
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

    function addWeight(product, maximum) {
        var target = $(`#weight-${product}`);
        var weight = parseInt(target.text());
        if (weight === maximum) {
            // do nothing
        } else {
            target.text(weight+1);
            if (weight+1 > 1) {
                var targetButton = $(`#subtract-${product}`);
                targetButton.html("");
                targetButton.text('-');
            }
        }
    }

    function subtractWeight(product) {
        var target = $(`#weight-${product}`);
        var weight = parseInt(target.text());
        if (weight === 1) {
            // delete item from cart
        } else {
            target.text(weight-1);
            var targetButton = $(`#subtract-${product}`);
            if (weight === 2) {
                // change icon to trash
                targetButton.html('<i class="fa fa-fw fa-trash-o"></i>');
            } else {
                // change text to -
                targetButton.html("");
                targetButton.text('-');
            }
        }
    }
</script>
@endsection
