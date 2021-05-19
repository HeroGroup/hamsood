@extends('layouts.admin', ['pageTitle' => 'لیست مشتری ها', 'newButton' => false])
@section('content')
<style>
/* The Modal (background) */
.custom-modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.custom-modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.custom-close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.custom-close:hover,
.custom-close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.custom-modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.custom-modal-body {padding: 2px 16px;}

    ul > li {
        padding:5px 10px;
    }

.col-xs-5, .col-xs-7 {
    overflow:hidden;
    text-overflow:ellipsis;
    display:-webkit-box;
    -webkit-line-clamp:1;
    -webkit-box-orient:vertical;
}

</style>
    <div class="panel panel-default">
        <div class="panel-heading">لیست مشتری ها</div>
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                @foreach($customers as $customer)
                <div class="custom-card col-md-3" style="padding:10px;color:#222;border:1px solid #222;">
                    <div class="row">
                        <div class="col-xs-5 control-label">نام:</div>
                        <div class="col-xs-7">{{$customer->gender ? config("enums.gender.$customer->gender") : ""}} {{$customer->name ?? '-'}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 control-label">موبایل:</div>
                        <div class="col-xs-7">{{$customer->mobile}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 control-label">معرف:</div>
                        <div class="col-xs-7">{{$customer->invitor ? \App\Customer::where('share_code','like',$customer->invitor)->first()->name : '-'}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 control-label">موجودی:</div>
                        <div class="col-xs-7">{{number_format($customer->balance) . ' تومان'}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 control-label">تاریخ عضویت:</div>
                        <div class="col-xs-7">{{jdate('Y/m/j', strtotime($customer->created_at))}}</div>

                    </div>
                    <div class="row">
                        <div class="btn-group" style="margin-left:15px;float:left;">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="padding:0;width:25px;border-radius:50%;">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu pull-left" role="menu">
                                <li>
                                    <a href="{{route('admin.customers.addresses', $customer->id)}}" class="btn btn-xs btn-info">لیست آدرس ها</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.customers.transactions', $customer->id)}}" class="btn btn-xs btn-success">لیست تراکنش ها</a>
                                </li>
                                <li>
                                    <a href="{{route('orders.index', ['availableProduct' => 0, 'customer' => $customer->id])}}" class="btn btn-xs btn-warning">لیست سفارش ها</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.customers.login', $customer->mobile)}}" class="btn btn-xs btn-danger">ورود به پنل مشتری</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const backgroundColors = [
            "lightred",
            "lightblue",
            "lightgreen",
            "lightyellow",
            "lightcoral",
            "lightcyan",
            "lightpink",
            "lightgoldenrodyellow",
            "lightsalmon",
            "lightseagreen",
            "lightseagreen",
            "lighrgray"
        ];

        $(document).ready(function() {
            $(".custom-card").each(function( index , element ) {
                $(this).css({"background-color" : randomColor() });
            });
        });

        function randomColor() {
            let index = Math.floor(Math.random() * 10) + 1;
            console.log(index);
            return backgroundColors[index];
        }

    </script>
@endsection
