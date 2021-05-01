@extends('layouts.customer', ['pageTitle' => 'پیام ها', 'withNavigation' => true, 'backUrl' => '/' ])
@section('content')
<div style="margin:70px 0;color:#222;">
    <div style="margin:10px;">
    @foreach($notifications as $notification)
        <div style="border:1px solid gray;border-radius:5px;padding:10px 30px;">
            <h3>{{$notification->notification_title}}</h3>
            <hr>
            <h4>{{$notification->notification_text}}</h4>
            <h6 style="color:gray;">{{jdate('l، d F Y ساعت H:i', strtotime($notification->created_at))}}</h6>
        </div>
    @endforeach
    </div>
</div>
@endsection
