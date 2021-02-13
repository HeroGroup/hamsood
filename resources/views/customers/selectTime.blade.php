@extends('layouts.customer', ['pageTitle' => 'زمان تحویل کالا', 'withNavigation' => true])
@section('content')
<div style="text-align:center;margin-top:80px;color:#222;">
    <img src="/images/select_time_icon.png" width="120" height="120" />
    <h4>{{$tomorrow}}</h4>
    <form method="post" action="{{route('customers.selectTime')}}">
        @csrf
        <div style="padding:5px 35px;height:160px;overflow:scroll;border-radius:5px;margin:5px 35px;box-shadow: 0 0 2px gray;">
            <?php $i=0; ?>
            @foreach($times as $key => $value)
                <div style="padding-top:7px;">
                    <?php $i++; ?>
                    <input type="radio" id="{{$key}}" name="times" value="{{$key}}" @if($i==1) checked @endif>
                    <label for="{{$key}}">{{$value}}</label><br>
                    @if(count($times) != $i) <hr style="border-color:lightgray; margin:10px 0;" /> @endif
                </div>
            @endforeach
        </div>

        <br />

        <p>زمان تحویل کالا حداکثر یک روز می باشد.</p>
        <p>لطفا زمان تقریبی دریافت کالا را مشخص کرده،</p>
        <p>و دکمه تائید را بفشارید.</p>

        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <button type="submit" class="btn confirm-button">
                تائید ساعت
            </button>
        </div>
    </form>
</div>
@endsection
