<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
        <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
        <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/css/my.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
        <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div>
            <div class="container">
                <h4 class="title">صفحه خرید گروهی</h4>
                <div>
                    <div class="circle">1</div>
                    <label class="steps">شروع</label>
                    <div class="circle">2</div>
                    <label class="steps">دعوت از دیگران</label>
                    <div class="circle">3</div>
                    <label class="steps">شروع خرید با تخفیف</label>
                </div>
                <hr class="horizontal-line">
                <div class="row" style="border:1px solid #E5E2E2;margin:5px 0;border-radius:3px;">
                    <div class="col-xs-8">
                        <label class="product-title">{{$product->name}}</label>
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
                    <div class="col-xs-4">
                        <img src="{{$product->image_url}}" width="90" height="90">
                    </div>
                </div>
                <h5 style="background-color:#EBF4FE;color:#222;text-align:center;padding-top:5px;padding-bottom:5px;">دیگران را دعوت کنید تا تخفیف ها آغاز شود</h5>
                <div style="text-align:center;color:#222;border: 1px solid #E5E2E2;padding: 10px 0; border-radius:3px;margin-bottom: 5px;">
                    <span> با </span>
                    <div class="circle">{{$peopleBought > 0 ? 1 : 2}}</div>
                    <span> نفر همسودی تخفیف </span>
                    <div class="badge red-badge">{{$nextDiscount}}% </div>
                    <span> آغاز می شود.</span>
                </div>

                <div style="border:1px solid #E5E2E2;border-radius:3px;padding: 5px;">
                    <div class="col-xs-6">
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
                    @endfor

                    <button id="hamsood-btn" onclick="buy()">منم همسود می شوم</button>

                    @if($userBought)
                        <div style="display: flex;flex-direction: row;border-radius: 3px;background-color:#E9D5BA;margin-top:-40px;">
                            <div style="flex:1;background-color:#FF6F00;text-align:center;padding:10px 0;">ارسال دعوت نامه</div>
                            <div style="flex:2;display: flex;flex-direction: row;justify-content: center;align-items: center;">
                                <div style="flex:1;text-align: center;" class="share">
                                    <a href="#"><img src="images/instagram.png" width="25" height="25" /></a>
                                </div>
                                <div style="flex:1;text-align: center;" class="share">
                                    <a href="#"><img src="images/telegram.png" width="25" height="25" /></a>
                                </div>
                                <div style="flex:1;text-align: center;" class="share">
                                    <a href="#"><img src="images/text-lines.png" width="25" height="25" /></a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div style="width: 100%; border-radius:3px;padding:5px;background-color:#E5E2E2;margin-top: 5px;">
                    <div style="width:100%;display: flex;justify-content: center;align-items: center;background-color:#9b59b6;color:white;">
                        <div style="flex:1;display: flex;flex-direction: row;justify-content: center;align-items: center;">
                            <span id="seconds" class="time-item">-</span>
                            <span>:</span>
                            <span id="minutes" class="time-item">-</span>
                            <span>:</span>
                            <span id="hours" class="time-item">-</span>
                            <span>:</span>
                            <span id="days" class="time-item">-</span>
                        </div>
                        <div style="flex:1;text-align: center;font-size: 18px;">زمان باقیمانده</div>
                    </div>
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
                </div>

                <div style="width: 100%; border-radius:3px;padding:5px;background-color:#E5E2E2;display: flex;margin-top: 5px;align-items: center;">
                    <div style="flex:1;text-align: center;color:#222;">
                        <h4>{{number_format($availableProduct->price)}} تومان</h4>
                        <h6>قیمت عادی</h6>
                    </div>
                    <div style="flex:1;text-align: left;">
                        <a class="btn btn-warning" href="http://hamsod.com" style="width:120px;">خرید</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/custom.js" type="text/javascript"></script>
        <script>
            window.onload = function() {
                countdown(parseInt("{{$remaining}}") * 1000);
                document.getElementById("hamsood-btn").style.visibility = "{{$userBought}}" ? "hidden" : "visible";

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
            }

            function buy() {
                window.location = '/verifyMobile';
            }

            function requestSMS() {
                swal({
                    text: "لینک خرید به زودی برای شما ارسال خواهد شد.",
                    buttons: ["باشه"],
                });
            }
        </script>
    </body>
</html>
