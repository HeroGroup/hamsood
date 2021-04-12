@extends('layouts.customer', ['pageTitle' => 'پرداخت ناموفق', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')
@include('layouts.bottomMenu')
<style>
    #back-button {
        border:1px solid lightgray;
        border-radius:5px;
        color:#222;
        text-decoration: none;
        padding:5px 10px;
    }
    #back-button:hover {
        background-color:#eee;
        text-decoration: none;
    }
</style>

<div style="text-align:center;color:#222;margin-top:150px;display:flex;justify-content:center;align-items:center;">
    <img src="/images/info_icon.png" width="30" height="30" />
    &nbsp;
    <h3 style="margin-bottom:revert;">پرداخت ناموفق!</h3>
</div>

<div style="margin-top:50px;text-align:center;">
    <a href="{{isset($back) ? $back : $backUrl}}" id="back-button">بازگشت به صفحه قبل</a>
</div>
@endsection
