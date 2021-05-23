@extends('layouts.customer', ['pageTitle' => 'پشتیبانی', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')
    <style>
        hr {
            margin-top:0;
            border: 1px solid #64498E;;
        }
    </style>
<div class="container" style="margin-top:70px;color:#222;">
    <div style="background-color:white;border-radius:5px;box-shadow: 0 0 3px #888888;padding:10px 15px;margin-bottom:25px;">
        <h4>فرم تماس</h4>
        <hr>
        <form method="post" action="{{route('postMessage')}}">
            @csrf
            <label for="message">متن پیام</label>
            <textarea rows="3" name="message" id="message" class="form-control" required></textarea>
            <button type="submit" class="btn" id="hamsood-btn" style="margin-top:15px;">ارسال</button>
        </form>
    </div>
    <div style="background-color:white;border-radius:5px;box-shadow: 0 0 3px #888888;padding:10px 15px;">
        <h4>اطلاعات تماس</h4>
        <hr>
        <div style="display: flex;">
            <div style="flex:1;">
                <i class="fa fa-map-marker" style="font-size:22px;color:#64498E;"></i>
                <label style="color:#64498E;">آدرس</label>
            </div>
            <div style="flex:2;padding:5px;">
                <label>میدان قائم ، کوچه 1 شهیدآیت اله ربانی، کوچه 3 آزادی، پلاک 8، طبقه همکف</label>
            </div>
        </div>
        <div style="display: flex;">
            <div style="flex:1;">
                <i class="fa fa-phone" style="font-size:18px;color:#64498E;transform:rotateY(180deg);"></i>
                <label style="color:#64498E;">شماره تلفن</label>
            </div>
            <div style="flex:2;padding:5px;">
                <label>07132282148</label>
            </div>
        </div>
        <div style="display: flex;">
            <div style="flex:1;">
                <i class="fa fa-envelope-o" style="font-size:18px;color:#64498E;"></i>
                <label style="color:#64498E;">آدرس ایمیل</label>
            </div>
            <div style="flex:2;padding:5px;">
                <label>support@hamsood.com</label>
            </div>
        </div>
    </div>
</div>
@endsection
