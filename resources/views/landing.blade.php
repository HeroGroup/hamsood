<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
        <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
        <link href="/css/my.css" rel="stylesheet" type="text/css">

        <style>
            .title {
                background-color:#9b59b6;
                color:white;
                padding:5px;
                text-align:center;
            }
            .circle {
                background-color:#74b9ff;
                text-align:center;
                border-radius:50%;
                align-items:center;
                width:25px;
                height:25px;
                display:inline-block;
                padding-top:2px;
            }
            .steps {
                color: #74b9ff;
                font-size: 11px;
                margin-left:5px;
            }
            .horizontal-line {
                border:2px solid #74b9ff;
            }
            .image {
                width:90px;
                height:90px;
                background-color:#74b9ff;
                margin-top:15px;
            }
            .product-title {
                color:black;
                text-align:center;
                padding-top:0;
                width:100%;
                font-size:16px;
            }
            p {
                color:black;
                width: 100%;
                text-align:center;

            }
        </style>
    </head>
    <body>
        <div class="">
            <div class="container">
                <h2 class="title">صفحه خرید گروهی</h2>
                <div>
                    <div class="circle">1</div>
                    <label class="steps">شروع</label>
                    <div class="circle">2</div>
                    <label class="steps">دعوت از دیگران</label>
                    <div class="circle">3</div>
                    <label class="steps">شروع خرید با تخفیف</label>
                </div>
                <hr class="horizontal-line">
                <div class="row" style="border:1px solid lightgray;margin:5px 0;border-radius:3px;">
                    <div class="col-xs-8">
                        <label class="product-title">گوجه فرنگی</label>
                        <div class="row">
                            <div class="col-xs-4" style="border-left:1px solid lightgray;">
                                <p style="font-size:10px;margin-bottom:5px;">قیمت بازار</p>
                                <p style="font-size:20px;margin-bottom:5px;margin-top:20px;">20,000</p>
                                <p style="font-size:10px;">تومان</p>
                            </div>
                            <div class="col-xs-4" style="border-left:1px solid lightgray;">
                                <p style="font-size:10px;margin-bottom:5px;">حداقل 2 نفر</p>
                                <p style="font-size:12px;margin-top:10px;margin-bottom:5px;">18,200</p>
                                <p style="color:red;font-size:18px;margin-bottom:5px;">9%</p>
                            </div>
                            <div class="col-xs-4">
                                <p style="font-size:10px;margin-bottom:5px;">حداکثر 10 نفر</p>
                                <p style="font-size:12px;margin-top:10px;margin-bottom:5px;">11,000</p>
                                <p style="color:red;font-size:18px;margin-bottom:5px;">45%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="image"></div>
                    </div>
                </div>
                <h5 style="background-color:#74b9ff;color:black;text-align:center;padding-top:5px;padding-bottom:5px;">دیگران را دعوت کنید تا تخفیف ها آغاز شود</h5>
            </div>
        </div>
    </body>
</html>
