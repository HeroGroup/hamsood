@extends('layouts.admin', ['pageTitle' => 'پشتیبانی'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">پشتیبانی</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>مشتری</th>
                        <th>متن پیام</th>
                        <th>زمان ایجاد</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($supports as $support)
                        <tr>
                            <td>{{$support->customer->name}} - {{$support->customer->mobile}}</td>
                            <td>{{$support->message}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($support->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
