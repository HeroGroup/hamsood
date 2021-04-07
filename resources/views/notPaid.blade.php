@extends('layouts.customer', ['pageTitle' => 'پرداخت ناموفق', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')
@include('layouts.bottomMenu')
<div style="text-align:center;color:#222;margin-top:150px;display:flex;justify-content:center;align-items:center;">
    <img src="/images/info_icon.png" width="30" height="30" />
    &nbsp;
    <h3 style="margin-bottom:revert;">پرداخت ناموفق!</h3>
</div>
@endsection
