@extends('layouts.admin', ['pageTitle' => 'لیست تراکنش ها '.(count($transactions) > 0 ? $transactions[0]->customer->name : ""), 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست تراکنش ها {{count($transactions) > 0 ? $transactions[0]->customer->name : ""}}</div>
        <div class="panel-body">
            <h3 class="text-success">موجودی لحظه ای: {{count($transactions) > 0 ? number_format($transactions[0]->customer->balance) : 0}} تومان</h3>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>بابت</th>
                        <th>مبلغ</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->title}}</td>
                            <td class="@if($transaction->transaction_type==1) text-success @else text-danger @endif">{{number_format($transaction->amount) . ($transaction->transaction_type==1 ? '+' : '-')}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($transaction->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
