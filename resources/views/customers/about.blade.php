@extends('layouts.customer', ['pageTitle' => 'درباره همسود', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')
    <style>
        hr {
            margin-top:5px;
            border: 1px solid #64498E;;
        }
        .main-div {
            margin-top:70px;
            margin-bottom:20px;
            color:#222;
            text-align: justify;
            border-radius:5px;
            box-shadow: 0 0 3px #888888;
            padding:10px 15px;
        }
    </style>
    <div class="container">
        <div class="main-div">
            <div>
                <img src="/images/logo.png" width="35" height="35" />
                &nbsp;
                <span style="font-size:20px;">همسود</span>
            </div>
            <hr style="border-color:#64498E;">
            <p>
                شاید تاکنون برای شما هم اتفاق افتاده باشد که کالایی را با قیمت و کیفیت مناسب بخرید و مطمئن بوده اید که دوستان و آشنایانتان هم به آن کالا نیاز دارند و احتمالا تاکنون حداقل یکبار تجربه خرید گروهی را داشته اید.
            </p>
            <p>
                به همین دلیل استارت آپ همسود (زیر مجموعه شرکت نوآوران بارکاونت تاسیس 1396) تصمیم دارد از این راه حل به هدف تامین میوه و تره بار مورد نیاز روزانه کاربران خود استفاده نماید.
            </p>
            <p>
                تیم همسود سامانه ای را طراحی نموده است که در آن به کاربران خود این امکان را میدهد که به روش خرید گروهی، سفارشات میوه و تره بار خود را در یک روز ثبت نموده و حداکثر تا 24 ساعت بعد از آن، سفارش خود را با قیمت ارزانتر و کیفیت بهتر تحویل گیرند.
            </p>
            <p>
                تیم استارت آپ همسود قصد دارد که در آینده کشاورزان بیشتری را جذب کرده تا آنها، محصولات خود را با کیفیت بهتر و بدون واسطه به دست مصرف کنندگان بیشتری برسانند.
            </p>
        </div>
    </div>
@endsection
