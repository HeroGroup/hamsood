@extends('layouts.customer', ['pageTitle' => 'جزيیات محصول', 'withNavigation' => true])
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
.semi-active {
    background-color: rgba(138,149,245,0.65)
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
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;padding-bottom:10px;">
            <div style="display:flex;flex-direction:row;padding:10px;">
                <div style="flex:1">
                    <img src="{{$product->image_url}}" style="width:100%;border:1px solid lightgray;border-radius:10px;padding:5px;" />
                </div>
                <div style="flex:2;text-align:center;">
                    <h4 style="margin-top:0;padding-top:0;">{{$product->name}}</h4>
                    <div style="text-align:right;padding-left:15px;padding-right:15px;font-size:12px;">
                        <?php echo $product->description ?>
                    </div>
                </div>
            </div>
            <div style="border:1px solid lightgray;border-radius:5px;margin:0 10px;">
                <div style="text-align:center;margin:10px 0">
                    <span style="color:white;background-color:#FF5A30;padding:2px 15px;border-radius:5px;">قیمت باراز {{number_format($availableProduct->price)}} تومان</span>
                </div>
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
                            <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->min('discount')}}%</b></p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;font-size:0.8em;text-align:center;">
                                <span class="text-badge bg-gray">همسودی</span>
                            </p>
                            <div style="flex:2;text-align:center;">
                                <p>{{number_format((100-$details->min('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
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
                                {{$availableProduct->maximum_group_members}}
                            </p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;text-align:center;font-size:0.8em;">
                                <span class="text-badge bg-red">تخفیف</span>
                            </p>
                            <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->max('discount')}}%</b></p>
                        </div>
                        <div style="display:flex;">
                            <p style="flex:1;font-size:0.8em;text-align:center;">
                                <span class="text-badge bg-gray">همسودی</span>
                            </p>
                            <div style="flex:2;text-align:center;">
                                <p>{{number_format((100-$details->max('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;overflow:hidden;margin-top:10px;">
            <h5 style="margin:0;background-color:#FF5A30;color:white;text-align:center;padding:10px 0;">دیگران را دعوت کنید تا تخفیف ها آغاز شود</h5>
            <br>
            <!--<div style="text-align:center;color:#222;font-size:0.9em;"></div>-->
            <br>
            <div style="display:flex;">
                <div style="flex:1;text-align:center;">
                    <div style="margin:0 15px;border:1px solid lightgray;border-radius:10px;overflow:hidden;box-shadow: 0 0 5px #888888;">
                        @for($i=$details->count()+1;$i>=1;$i--)
                            <p class="people @if($peopleBought>=$i) people-active @elseif($i==1 || $i==2) semi-active @endif" style="@if($i<=$peopleBought && $i>1) border:none; @elseif($i!=1) border-bottom:1px solid lightgray; @endif"><b>{{$i}}</b></p>
                        @endfor
                    </div>
                    <img src="/images/people_icon.png" width="40" height="40" />
                    <p>نفرات</p>
                </div>
                    <div style="flex:1;text-align:center;">
                        <div style="margin:0 15px;border:1px solid lightgray;border-radius:10px;overflow:hidden;box-shadow: 0 0 5px #888888;">
                            <p>با </p>
                            <p class="circle">{{$peopleBought > 0 ? 1 : 2}}</p><span> نفر </span>
                            <p>همسودی </p>
                            <p>تخفیف </p>
                            <p class="badge red-badge">{{$nextDiscount}}% </p>
                            <p> آغاز</p>
                            <p style="margin:3px;">می شود.</p>
                        </div>
                        <img src="/images/alert_icon.png" width="40" height="40" />
                    </div>
                <div style="flex:1;text-align:center;">
                    <div style="margin:0 15px;border:1px solid lightgray;border-radius:10px;overflow:hidden;box-shadow: 0 0 5px #888888;">
                        @for($i=$details->count()-1;$i>=1;$i--)
                            <p class="discount @if($peopleBought>=$i+2) discount-active @endif" style="@if($peopleBought>=$i+2) border:none; @else border-bottom:1px solid lightgray; @endif"><b>{{$details[$i]->discount ?? '-'}}%</b></p>
                        @endfor
                        <p class="discount @if($peopleBought>1) discount-active @endif" style="padding:20px 0;"><b>{{$details->min('discount') ?? '-'}}%</b></p>
                    </div>
                    <img src="/images/discount_icon.png" width="40" height="40" />
                    <p>تخفیف</p>
                </div>
            </div>
        </div>

        @if($userCartWeight > 0)
        <div class="hamsood-button-container" style="background-color:#8A95F5;">
            <div style="display:flex;width:50%;margin-right:25%;">
                <button class="add-subtract-button" style="flex:1" onclick="addWeight('{{$availableProduct->id}}', 4)">+</button>
                <span id="weight-{{$availableProduct->id}}" style="flex:1;margin:0 15px;font-size:16px;">{{$userCartWeight}}</span>
                <button class="add-subtract-button" style="flex:1" onclick="subtractWeight('{{$availableProduct->id}}')">
                    @if($userCartWeight > 1) - @else <i class="fa fa-fw fa-trash-o"></i> @endif
                </button>
            </div>
        </div>
        @elseif($userWeight > 0)
        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <!--<a class="btn" href="{{route('customers.orders.products', $orderId)}}" style="border-color:#64498E;width:100%;color:#64498E;">جزيیات سفارش</a>-->
            <button class="btn share-btn" onclick="share(0,'{{$product->id}}')">ارسال دعوتنامه <i class="fa fa-fw fa-share"></i></button>
        </div>
        @else
        <div class="hamsood-button-container">
            <button id="hamsood-btn" class="hamsood-btn" onclick="buy('{{$product->id}}')">اضافه به سبد خرید</button>
        </div>
        @endif

    </div>
</div>

@component('components.loader')@endcomponent

<script src="/js/custom.js" type="text/javascript"></script>
<script>
    window.onload = function() {
        $("#main-div").parent().css({"background-color":"#eee"});
        countdown(parseInt("{{$remaining}}") * 1000);

        /*
        $('.share').on('click', function() {
            var $temp = $("<input>"), $url = $(location).attr('href');
            $("body").append($temp);
            $temp.val($url).select();
            document.execCommand("copy");
            $temp.remove();
            swal({
                text: "آدرس صفحه کپی شد!",
                buttons: ["باشه"],
            });
        });
        */
    };

    function buy(product) {
        turnOnLoader();
        window.location.href = `/order/addToCart/${product}`;
    }

    function requestSMS() {
        swal({
            text: "لینک خرید به زودی برای شما ارسال خواهد شد.",
            buttons: ["باشه"],
        });
    }
</script>
@endsection
