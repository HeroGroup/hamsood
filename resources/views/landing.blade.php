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
                    <div class="badge red-badge">9% </div>
                    <span> آغاز می شود.</span>
                </div>
                <br>
                <div style="border:1px solid lightgray;border-radius:3px;padding: 5px;">
                    <div class="suggest-card-container">
                        <div style="flex:1;">
                            <div class="suggest-card">
                                <div class="half-suggest-card">
                                    <span>9%</span>
                                    <span style="font-size: 10px;">تعداد</span>
                                    <span class="custom-badge">2 نفر</span>
                                </div>
                                <div class="half-suggest-card">
                                    <div class="circle" style="width:35px;height:35px;">
                                        <i class="fa fa-user" style="color:lightgray;font-size:20px;"></i>
                                    </div>
                                    <span class="custom-badge" style="margin-top:8px;">منتظر</span>
                                </div>
                                <div class="half-suggest-card">
                                    <div class="circle" style="width:35px;height:35px;">
                                        <i class="fa fa-user" style="color:lightgray;font-size:20px;"></i>
                                    </div>
                                    <span class="custom-badge" style="margin-top:8px;">منتظر</span>
                                </div>
                            </div>
                        </div>
                        <div style="flex:1;display: flex;flex-direction: row;">
                            @component('components.suggestCard', ['percent' => '12%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                            @component('components.suggestCard', ['percent' => '17%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        </div>
                    </div>
                    <div class="suggest-card-container">
                        @component('components.suggestCard', ['percent' => '23%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        @component('components.suggestCard', ['percent' => '26%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        @component('components.suggestCard', ['percent' => '31%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        @component('components.suggestCard', ['percent' => '36%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                    </div>
                    <div class="suggest-card-container">
                        @component('components.suggestCard', ['percent' => '38%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        @component('components.suggestCard', ['percent' => '42%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        @component('components.suggestCard', ['percent' => '51%', 'people' => '1', 'status' => 'منتظر'])@endcomponent
                        <div class="suggest-card" style="background-color: transparent;"></div>
                    </div>
                    <br>
                    <div style="width:100%;">
                        <button style="width:100%;padding:10px;border-radius:3px;background-color:#e67e22;color:white;border:none;">منم همسود می شوم</button>
                    </div>
                </div>
                <div style="width: 100%; border-radius:3px;padding:5px;background-color:lightgray;margin-top: 5px;">
                    <div style="width:100%;display: flex;justify-content: center;align-items: center;background-color:#9b59b6;color:white;">
                        <div style="flex:1;display: flex;flex-direction: row;justify-content: center;align-items: center;">
                            <span style="width:30px;background-color: white;color:black;padding:5px;text-align: center;height: 30px;margin:5px;">59</span>
                            <span>:</span>
                            <span style="width:30px;background-color: white;color:black;padding:5px;text-align: center;height: 30px;margin:5px;">59</span>
                            <span>:</span>
                            <span style="width:30px;background-color: white;color:black;padding:5px;text-align: center;height: 30px;margin:5px;">23</span>
                        </div>
                        <div style="flex:1;text-align: center;font-size: 18px;">زمان باقیمانده</div>
                    </div>
                </div>

                <div style="width: 100%; border-radius:3px;padding:5px;background-color:lightgray;display: flex;margin-top: 5px;align-items: center;">
                    <div style="flex:1;text-align: center;color:#222;">
                        <h4>20,000</h4>
                        <h5>تومان</h5>
                        <h5>قیمت عادی</h5>
                    </div>
                    <div style="flex:1;text-align: left;">
                        <button class="btn btn-warning" style="width:80px;font-size: 20px;">خرید</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
