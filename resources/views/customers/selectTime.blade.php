@extends('layouts.customer', ['pageTitle' => 'زمان تحویل کالا', 'withNavigation' => true])
@section('content')
<div style="text-align:center;margin-top:80px;color:#222;">
    <img src="/images/select_time_icon.png" width="120" height="120" />
    <h4>{{$tomorrow}}</h4>
    <form method="post" action="{{route('customers.selectTime')}}" id="select-time-form">
        @csrf
        <div style="padding:5px 35px;height:160px;overflow:scroll;border-radius:5px;margin:5px 35px;box-shadow: 0 0 2px gray;">
            <?php $i=0; ?>
            @foreach($times as $time)
                <div style="padding-top:7px;display:flex;">
                    <?php $i++; ?>
                    <div style="flex:1;">
                        <input type="radio" id="{{$time->id}}" name="times" value="{{$time->id}}" @if($i==1) checked @endif>
                        <label for="{{$time->id}}">{{$time->delivery_start_time}} - {{$time->delivery_end_time}}</label>
                    </div>
                    <div style="flex:1;text-align:center;">
                        <span>{{$time->delivery_fee_for_now > 0 ? number_format($time->delivery_fee_for_now) . ' تومان' : 'رایگان'}}</span>
                    </div>
                    <br>
                </div>
                @if(count($times) != $i)
                    <hr style="border-color:lightgray; margin:10px 0;" />
                @endif
            @endforeach
        </div>

        <br />

        <p>زمان تحویل کالا حداکثر یک روز می باشد.</p>
        <p>لطفا زمان تقریبی دریافت کالا را مشخص کرده،</p>
        <p>و دکمه تائید را بفشارید.</p>

        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <button type="button" class="btn confirm-button" onclick="submitTime()" id="submit-button">
                تائید ساعت
            </button>
        </div>
    </form>
</div>

<script>
function submitTime() {
    // $("#submit-button").prop("disabled",true);
    document.getElementById("select-time-form").submit();
}
</script>
@endsection
