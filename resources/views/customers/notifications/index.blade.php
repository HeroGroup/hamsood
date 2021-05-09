@extends('layouts.customer', ['pageTitle' => 'پیام ها', 'withNavigation' => true, 'backUrl' => '/' ])
@section('content')

@include('layouts.bottomMenu')

<div style="margin:70px 0;color:#222;">
    <div style="margin:10px;">
    @if($notifications->count() > 0)
    @foreach($notifications as $notification)
        <div style="border:1px solid gray;border-radius:5px;padding:10px 30px;">
            <h3>{{$notification->notification_type === 1 ? "تسویه حساب" : $notification->notification_title}}</h3>
            <hr>
            <h4>{{$notification->notification_type === 1 ? "تسویه حساب نهایی انجام شد و مبلغ $notification->notification_text به کیف پول شما برگشت داده شد." : $notification->notification_text}}</h4>
            <h6 style="color:gray;">{{jdate('l، d F Y ساعت H:i', strtotime($notification->created_at))}}</h6>
        </div>
    @endforeach
    @else
    <h4 style="color:gray;text-align: center;padding-top:30px;">هنوز پیامی ندارید.</h4>
    @endif
    </div>
</div>
@endsection
