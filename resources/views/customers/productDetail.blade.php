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
        <div class="hamsood-button-container">
        @if($userCartWeight > 0)
            <button style="border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;font-size:20px;font-weight:bold;width:35px;border-radius:5px;">+</button>
            <span style="margin:0 15px;font-size:20px;">1</span>
            <button style="border:none;background-color:white;box-shadow:0 0 3px #888888;color:#222;font-size:20px;font-weight:bold;width:35px;border-radius:5px;">-</button>
        @elseif($userWeight > 0)
            <button class="btn" style="background-color:#64498E;width:100%;color:white">جزيیات سفارش</button>
        @else
            <button id="hamsood-btn" class="hamsood-btn" onclick="buy('{{$product->id}}')">اضافه به سبد خرید</button>
        @endif
        </div>
    </div>
</div>

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

    $('.share').on('click', async () => {
        const reference = "{{$referenceId}}";
        const shareData = {
            title: 'همسود',
            text: 'شما هم در این خرید، همسود شوید',
            url: 'https://survey.porsline.ir/s/gP5ZKVE/' // 'https://hamsod.com/landing/'+reference,
        };
        try {
            await navigator.share(shareData)
            // resultPara.textContent = 'MDN shared successfully'
        } catch(err) {
            // resultPara.textContent = 'Error: ' + err
        }
    });

    function buy(product) {
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
