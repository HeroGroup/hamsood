<style>
.col-xs-3, .col-xs-6 {
    padding-left:2px;
    padding-right:2px;
    margin-left:0;
    margin-right:0;
    margin-bottom:5px;
}
</style>
<div class="col-xs-3">
    <div class="suggest-card" @if($status==2)style="background-color:#b8f5b8;"@endif>
        <div class="half-suggest-card">
            <span>{{$percent}}</span>
            <span style="font-size: 10px;">تعداد</span>
            <span class="custom-badge">{{$status==2 ? 'تکمیل' : "$people نفر"}}</span>
        </div>
        <div class="half-suggest-card">
            <div class="circle" style="width:35px;height:35px;background-color: transparent;border:2px solid gray;">
                @if($status==1)
                    <img src="images/ic_person_add.png" width="22" height="16">
                @else
                    <img src="images/ic_mood.png" width="36" height="36">
                @endif
            </div>
            <span class="custom-badge" style="margin-top:8px;@if($status == 2) background-color:green;color:white; @endif">{{$status == 1 ? 'منتظر' : 'تایید'}}</span>
        </div>
    </div>
</div>
