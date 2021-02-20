@extends('layouts.customer', ['pageTitle' => 'سفارش', 'withMenu' => true])
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
<div id="main-div" style="margin-top:70px;margin-bottom:60px;background-color:#eee;color:#222;">
    <div class="container">
        <!-- <h4 class="title">صفحه خرید گروهی</h4>
        <div>
            <div class="circle">1</div>
            <label class="steps">شروع</label>
            <div class="circle">2</div>
            <label class="steps">دعوت از دیگران</label>
            <div class="circle">3</div>
            <label class="steps">شروع خرید با تخفیف</label>
        </div>
        <hr class="horizontal-line"> -->
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;">
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
            <p style="color:gray;text-align: center;">قیمت باراز {{number_format($availableProduct->price)}} تومان</p>
            <div style="display:flex;flex-direction:row;color:gray;">
                <!-- <div style="flex:1;text-align:center;border-left:1px solid lightgray;padding:5px;">
                    <p>قیمت</p>
                    <p>{{number_format($availableProduct->price)}}</p>
                    <p>تومان</p>
                </div> -->
                <div style="flex:2;border-left:1px solid lightgray;text-align:center;padding:5px;">
                    <p><b>۲ نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->min('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$details->min('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
                <div style="flex:2;text-align:center;padding:5px;">
                    <p><b>{{$availableProduct->maximum_group_members}} نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->max('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$details->max('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;overflow:hidden;margin-top:10px;">
            <h5 style="margin:0;background-color:#FF5A30;color:white;text-align:center;padding:10px 0;">دیگران را دعوت کنید تا تخفیف ها آغاز شود</h5>
            <br>
            <div style="text-align:center;color:#222;font-size:0.9em;/*border: 1px solid lightgray;border-radius:10px;*/">
                <span>با </span>
                <span class="circle">{{$peopleBought > 0 ? 1 : 2}}</span>
                <span> نفر همسودی تخفیف </span>
                <span class="badge red-badge">{{$nextDiscount}}% </span>
                <span> آغاز می شود.</span>
            </div>
            <br>
            <div style="display:flex;">
                <div style="flex:1;text-align:center;">
                    <div style="margin:0 35px;border:1px solid lightgray;border-radius:10px;overflow:hidden;box-shadow: 0 0 5px #888888;">
                        @for($i=$details->count()+1;$i>=1;$i--)
                            <p class="people @if($peopleBought>=$i) people-active @endif" style="@if($i<=$peopleBought && $i>1) border:none; @elseif($i!=1) border-bottom:1px solid lightgray; @endif"><b>{{$i}}</b></p>
                        @endfor
                    </div>
                    <img src="/images/people_icon.png" width="40" height="40" />
                    <p>نفرات</p>
                </div>
                <div style="flex:1;text-align:center;">
                    <div style="margin:0 35px;border:1px solid lightgray;border-radius:10px;overflow:hidden;box-shadow: 0 0 5px #888888;">
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
        <!-- <div class="row" style="border:1px solid #E5E2E2;margin:5px 0;border-radius:3px;z-index:0;">
            <div class="col-xs-8">
                <label class="product-title"></label>
                <div class="row">
                    <div class="col-xs-4" style="border-left:1px solid #E5E2E2;">
                        <p class="p-text mb-5">قیمت بازار</p>
                        <p class="p-text mb-5" style="font-size:20px;margin-top:5px;">{{number_format($availableProduct->price)}}</p>
                        <p class="p-text">تومان</p>
                    </div>
                    <div class="col-xs-4" style="border-left:1px solid #E5E2E2;">
                        <p class="p-text mb-5">حداقل 2 نفر</p>
                        <p class="p-text mb-5" style="font-size:12px;margin-top:10px;">{{number_format((100-$details->min('discount'))/100*$availableProduct->price)}}</p>
                        <p class="p-text mb-5" style="color:red;font-size:18px;">{{$details->min('discount')}}%</p>
                    </div>
                    <div class="col-xs-4">
                        <p class="p-text" style="margin-bottom:5px;">حداکثر {{$availableProduct->maximum_group_members}} نفر</p>
                        <p class="p-text mb-5" style="font-size:12px;margin-top:10px;">{{number_format((100-$details->max('discount'))/100*$availableProduct->price)}}</p>
                        <p class="p-text mb-5" style="color:red;font-size:18px;">{{$details->max('discount')}}%</p>
                    </div>
                </div>
            </div>
        </div> -->


            <!-- <div class="col-xs-6">
                <div class="suggest-card" @if($peopleBought>0)style="background-color:#b8f5b8;"@endif>
                    <div class="half-suggest-card">
                        <span>{{$details->min('discount')}}%</span>
                        <span style="font-size: 10px;">تعداد</span>
                        <span class="custom-badge">{{$peopleBought>1 ? 'تکمیل' : '2 نفر'}}</span>
                    </div>
                    <div class="half-suggest-card">
                        <div class="circle" style="width:35px;height:35px;background-color: transparent;border:2px solid gray;">
                            @if($peopleBought>0)
                                <img src="images/ic_mood.png" width="36" height="36">
                            @else
                                <img src="images/ic_person_add.png" width="22" height="16">
                            @endif
                        </div>
                        <span class="custom-badge" style="margin-top:8px;@if($peopleBought>0) background-color:green;color:white; @endif">{{$peopleBought>0 ? 'تایید' : 'منتظر'}}</span>
                    </div>
                    <div class="half-suggest-card">
                        <div class="circle" style="width:35px;height:35px;background-color: transparent;border:2px solid gray;">
                            @if($peopleBought>1)
                                <img src="images/ic_mood.png" width="36" height="36">
                            @else
                                <img src="images/ic_person_add.png" width="22" height="16">
                            @endif
                        </div>
                        <span class="custom-badge" style="margin-top:8px;@if($peopleBought>1) background-color:green;color:white; @endif">{{$peopleBought>1 ? 'تایید' : 'منتظر'}}</span>
                    </div>
                </div>
            </div>
            @for($i=1;$i<=$details->count()-1;$i++)
                @component('components.suggestCard', ['percent' => $details[$i]->discount."%", 'people' => '1', 'status' => $i<=$peopleBought-2 ? 2 : 1])@endcomponent
            @endfor -->


            <div style="margin-top:10px;display:flex;justify-content:center;align-items:center;background-color:#FAC850;color:#444;border-radius:10px;box-shadow: 0 0 5px #888888;">
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
            <!--<button id="styling-button" style="visibility:hidden;">منم همسود می شوم</button>-->
            <div class="hamsood-button-container">
              @if($userBought)
                <div style="display: flex;flex-direction: row;border-radius: 3px;background-color:#E9D5BA;">
                    <div style="flex:1;background-color:#FF6F00;text-align:center;padding:10px 0;">ارسال دعوت نامه</div>
                    <div style="flex:2;display: flex;flex-direction: row;justify-content: center;align-items: center;">
                        <div style="flex:1;text-align: center;" class="share">
                            <a href="#"><img src="/images/instagram.png" width="25" height="25" /></a>
                        </div>
                        <div style="flex:1;text-align: center;" class="share">
                            <a href="#"><img src="/images/telegram.png" width="25" height="25" /></a>
                        </div>
                        <div style="flex:1;text-align: center;" class="share">
                            <a href="#"><img src="/images/text-lines.png" width="25" height="25" /></a>
                        </div>
                    </div>
                </div>
                @else
                  <button id="hamsood-btn" onclick="buy()">منم همسود می شوم</button>
                  @endif
            </div>



        <!-- <div style="width: 100%; border-radius:3px;padding:5px;background-color:#E5E2E2;margin-top: 5px;">
            <div style="display:flex;flex-direction:row;margin-top:10px;">
                <div style="flex:2;display:flex;flex-direction:column;text-align:center;">
                    <div style="flex:2;display:flex;">
                        <div style="flex:1;font-size:16px;color:red;">{{number_format((100-$lastDiscount)/100*$availableProduct->price)}} تومان</div>
                        <div style="flex:1;font-size:16px;color:red;border:1px solid red;margin:0 5px;">{{$lastDiscount}}%  تخفیف</div>
                    </div>
                    <div style="flex:1;color:#222;font-size:10px;">فعال شدن تخفیف با شروع همسود</div>
                </div>
                <div style="flex:1;text-align: left;">
                    <button class="btn" onclick="requestSMS()" @if($userBought) style="width:120px;background-color:green;" @else style="width:120px;background-color:gray;cursor:not-allowed;" disabled @endif>
                        @if(!$userBought)
                            <img src="images/ic_lock.png" width="16" height="21" />
                        @endif
                        خرید
                    </button>
                </div>
            </div>
        </div> -->

        <!-- <div style="width: 100%; border-radius:3px;padding:5px;background-color:#E5E2E2;display: flex;margin-top: 5px;align-items: center;">
            <div style="flex:1;text-align: center;color:#222;">
                <h4>{{number_format($availableProduct->price)}} تومان</h4>
                <h6>قیمت عادی</h6>
            </div>
            <div style="flex:1;text-align: left;">
                <a class="btn btn-warning" href="{{$product->base_price_url}}" style="width:120px;">خرید</a>
            </div>
        </div> -->
    </div>
</div>

<script src="/js/custom.js" type="text/javascript"></script>
<script>
    window.onload = function() {
        $("#main-div").parent().css({"background-color":"#eee"});
        countdown(parseInt("{{$remaining}}") * 1000);
        // document.getElementById("styling-button").style.visibility = "{{$userBought}}" ? "hidden" : "visible";

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

    $('.share').on('click', async () => {
        const reference = "{{$referenceId}}";
        const shareData = {
            title: 'همسود',
            text: 'شما هم در این خرید، همسود شوید',
            url: 'https://hamsod.com/landing/'+reference,
        };
        try {
            await navigator.share(shareData)
            // resultPara.textContent = 'MDN shared successfully'
        } catch(err) {
            // resultPara.textContent = 'Error: ' + err
        }
    });

    function buy() {
        window.location = "{{route('customers.orderProduct', ['product' => $product->id])}}";
    }

    function requestSMS() {
        swal({
            text: "لینک خرید به زودی برای شما ارسال خواهد شد.",
            buttons: ["باشه"],
        });
    }
</script>
@endsection
