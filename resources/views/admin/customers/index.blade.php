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

    .btn-group > ul > li {
        padding:5px 10px;
    }

</style>
    <div class="panel panel-default">
        <div class="panel-heading">لیست مشتری ها</div>
        <div class="tab">
            <label style="padding-right:40px;">نمایش: </label>
            <button class="tablinks active" onclick="window.location = '/admin/customers';">
                <i class="fa fa-list"></i>
            </button>
            <button class="tablinks" onclick="window.location = '/admin/customers?view=tile';">
                <i class="fa fa-th-large"></i>
            </button>
        </div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>شماره موبایل</th>
                        <th>جنسیت</th>
                        <th>معرف</th>
                        <th>موجودی کیف پول</th>
                        <th>تاریخ عضویت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->mobile}}</td>
                            <td>{{$customer->gender ? config("enums.gender.$customer->gender") : ""}}</td>
                            <td>{{$customer->invitor ? \App\Customer::where('share_code','like',$customer->invitor)->first()->name : '-'}}</td>
                            <td>{{number_format($customer->balance) . ' تومان'}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($customer->created_at))}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                        عملیات
                                        <span class="caret"></span>
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
