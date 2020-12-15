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
                font-size: 16px;
                color:white;
            }
            .steps {
                color: #74b9ff;
                font-size: 14px;
                margin-left:5px;
            }
            .horizontal-line {
                border:2px solid #74b9ff;
                margin: 10px 0;
            }
            .image {
                width:90px;
                height:90px;
                background-color: #bfe5ff;
                margin-top:5px;
            }
            .product-title {
                color:#222;
                text-align:center;
                padding-top:0;
                width:100%;
                font-size:16px;
            }
            .p-text {
                color:#222;
                width: 100%;
                text-align:center;
                font-size:10px;
            }
            .mb-5 {
                margin-bottom: 5px;
            }
            .suggest-card-container {
                display: flex;
                flex-direction: row;
                margin:5px 0;
            }
            .suggest-card {
                border-radius:5px;
                background-color: #f0f0f0;
                color: #9b59b6;
                height:80px;
                margin:0 5px;
                flex:1;
            }
            .custom-badge {
                font-size:20px;
                background-color: red;
                padding:5px 10px;
            }
        </style>
    </head>
    <body>
        <div class="">
            <div class="container">
                <h3 class="title">صفحه خرید گروهی</h3>
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
                                <p class="p-text mb-5">قیمت بازار</p>
                                <p class="p-text mb-5" style="font-size:20px;">20,000</p>
                                <p class="p-text">تومان</p>
                            </div>
                            <div class="col-xs-4" style="border-left:1px solid lightgray;">
                                <p class="p-text mb-5">حداقل 2 نفر</p>
                                <p class="p-text mb-5" style="font-size:12px;margin-top:10px;">18,200</p>
                                <p class="p-text mb-5" style="color:red;font-size:18px;">9%</p>
                            </div>
                            <div class="col-xs-4">
                                <p class="p-text" style="margin-bottom:5px;">حداکثر 10 نفر</p>
                                <p class="p-text mb-5" style="font-size:12px;margin-top:10px;">11,000</p>
                                <p class="p-text mb-5" style="color:red;font-size:18px;">45%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="image"></div>
                    </div>
                </div>
                <h5 style="background-color:#74b9ff;color:#222;text-align:center;padding-top:5px;padding-bottom:5px;">دیگران را دعوت کنید تا تخفیف ها آغاز شود</h5>
                <div style="text-align:center;color:#222;border: 1px solid lightgray;padding: 10px 0; border-radius:3px;">
                    <span> با </span>
                    <div class="circle">2</div>
                    <span> نفر همسودی تخفیف </span>
                    <div class="badge custom-badge">9% </div>
                    <span> آغاز می شود.</span>
                </div>
                <br>
                <div style="border:1px solid lightgray;border-radius:3px;padding: 5px;">
                    <div class="suggest-card-container">
                        <div style="flex:1;">
                            <div class="suggest-card">
                                //
                            </div>
                        </div>
                        <div style="flex:1;display: flex;flex-direction: row;">
                            <div class="suggest-card">

                            </div>
                            <div class="suggest-card"></div>
                        </div>
                    </div>
                    <div class="suggest-card-container">
                        <div class="suggest-card"></div>
                        <div class="suggest-card"></div>
                        <div class="suggest-card"></div>
                        <div class="suggest-card"></div>
                    </div>
                    <div class="suggest-card-container">
                        <div class="suggest-card"></div>
                        <div class="suggest-card"></div>
                        <div class="suggest-card"></div>
                        <div class="suggest-card" style="background-color: transparent;"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
