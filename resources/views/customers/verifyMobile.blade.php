@extends('layouts.customer', ['pageTitle' => 'شماره موبایل'])
@section('content')

<div class="container" style="text-align:center;">
    <div style="margin-top:50px;">
        <div>
            <img src="images/verify_mobile.png" width="150" height="150" />
        </div>
        <div style="flex:1;color:#222;margin-top:50px;">
            <p>جهت وارد شدن در فروشگاه اینترنتی</p>
            <p>خرید گروهی <b>همسود</b></p>
            <p>شماره تلفن همراه خود را وارد کنید</p>
        </div>
    </div>
    <div>
        <form action="{{route('verifyMobile')}}" method="post">
            @csrf
            <div style="display:flex;justify-content:center;">
                <div class="input-container">
                    <i class="fa fa-fw fa-mobile icon"></i>
                    <input class="input-field" type="text" name="mobile" maxlength="11" inputmode="numeric">
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <p style="color:red;margin-top:5px;text-align: center;">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </p>
            @endif
            <div style="position:fixed;bottom:0;left:0;width:100%;">
                <button class="btn btn-success" style="width:100%;padding: 15px 0;border-radius:0;font-size:20px;" type="submit">
                    دریافت کد
                </button>
            </div>
        </form>
    </div>
</div>
