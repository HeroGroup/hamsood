@extends('layouts.customer', ['pageTitle' => 'سفارش', 'withMenu' => true])
@section('content')
<style>
.bottom-menu {
  overflow: hidden;
  background-color: white;
  position: fixed;
  bottom: 0;
  width: 100%;
  display:flex;
  justify-content:space-between;
}

.bottom-menu a {
  flex:1;
  /*float: left;*/
  /*display: block;*/
  color: #222;
  text-align: center;
  padding: 4px 6px;
  text-decoration: none;
  font-size: 10px;
}

.bottom-menu a span {
    margin-top:3px;
}

.bottom-menu a:hover {
  background: #ddd;
  color: black;
}

.text-badge {
    display:inline-block;
    width:50px;
    color:white;
    padding:2px;
    border-radius:5px;
    text-align:center;
}
.bg-red {
    background-color:red;
}
.bg-gray {
    background-color:gray;
}
.people {
    font-size:1em;
    color:#64498F;
    background-color:#DDE1FD;
    margin:0;
    padding:5px 0;
}
.people-active {
    background-color:#8A95F5;
    border-color:#8A95F5;
}
.discount {
    font-size:1em;
    color:#64498F;
    background-color:#FCE1E3;
    margin:0; padding:5px 0;

}
.discount-active {
    background-color:#FB5152;
    color:white;
}
</style>
<div class="bottom-menu">
  <a href="{{route('customers.orders')}}">
      <div><img src="/images/home_icon.png" width="25" height="25" /></div>
      <span>سفارش ها</span>
  </a>
  <a href="#home">
    <div><img src="/images/home_icon.png" width="25" height="25" /></div>
    <span>خانه</span>
  </a>
  <a href="#profile">
      <div><img src="/images/profile_icon.png" width="18" height="18" style="margin:3px;" /></div>
      <span>پروفایل</span>
  </a>
</div>
<div id="main-div" style="margin-top:70px;margin-bottom:70px;background-color:#eee;color:#222;">
    <div class="container">
        <div style="margin-bottom:10px;display:flex;justify-content:center;align-items:center;background-color:#FAC850;color:#444;border-radius:10px;box-shadow: 0 0 5px #888888;">
            <div class="clock-container">
                <span id="seconds" class="time-item">-</span>
                <span id="minutes" class="time-item">-</span>
                <span id="hours" class="time-item">-</span>
                <span id="days" class="time-item">-</span>
            </div>
            <div style="flex:1;text-align:center;font-size:1em;margin-top:10px;">
                <img src="/images/clock_icon.png" width="40" height="40" />
                <p>زمان باقیمانده</p>
            </div>
        </div>
        <div style="background-color:white;border-radius:10px;box-shadow: 0 0 5px #888888;">
            <div style="display:flex;flex-direction:row;padding:10px;">
                <div style="flex:1">
                    <img src="{{$product->image_url}}" style="width:100%;border:1px solid lightgray;border-radius:10px;padding:5px;" />
                </div>
                <div style="flex:2;text-align:center;">
                    <h4 style="margin-top:0;padding-top:0;">{{$product->name}}</h4>
                    <div style="text-align:right;padding-left:15px;padding-right:15px;font-size:12px;">
                        <?php echo $product->description ?>
                    </div>
                </div>
            </div>
            <p style="color:gray;text-align: center;">قیمت باراز {{number_format($availableProduct->price)}} تومان</p>
            <div style="display:flex;flex-direction:row;color:gray;">
                <div style="flex:2;border-left:1px solid lightgray;text-align:center;padding:5px;">
                    <p><b>۲ نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->min('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$details->min('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
                <div style="flex:2;text-align:center;padding:5px;">
                    <p><b>{{$availableProduct->maximum_group_members}} نفر همسودی</b></p>
                    <div style="display:flex;">
                        <p style="flex:1;text-align:center;font-size:1em;">
                            <span class="text-badge bg-red">تخفیف</span>
                        </p>
                        <p style="flex:2;text-align:center;color:red;font-size:1.5em;"><b>{{$details->max('discount')}}%</b></p>
                    </div>
                    <div style="display:flex;">
                        <p style="flex:1;font-size:1em;text-align:center;">
                            <span class="text-badge bg-gray">قیمت</span>
                        </p>
                        <div style="flex:2;text-align:center;">
                            <p>{{number_format((100-$details->max('discount'))/100*$availableProduct->price)}} <span style="font-size:10px;">تومان</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/custom.js" type="text/javascript"></script>
<script>
    window.onload = function() {
        $("#main-div").parent().css({"background-color":"#eee"});
        countdown(parseInt("{{$remaining}}") * 1000);
    };
</script>
@endsection
