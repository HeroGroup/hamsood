@extends('layouts.customer', ['pageTitle' => 'کیف پول', 'withNavigation' => true, 'backUrl' => '/' ])
@section('content')
<div style="margin:70px 0;color:#222;">
    <div class="tab-container">
        <a href="{{route('customers.wallet')}}" id="products" class="tab-item">افزایش اعتبار</a>
        <a href="{{route('customers.transactions')}}" id="address" class="tab-item selected">تراکنش های من</a>
    </div>

    <div style="margin:10px;">
    @foreach($transactions as $transaction)
        <div style="display:flex;align-items:center;">
            <div style="flex:1;">
                <h4>{{$transaction->title}}</h4>
                <p style="color:gray;">{{jdate('l، d F Y - H:i', strtotime($transaction->created_at))}}</p>
            </div>
            <h3 style="flex:1;text-align:center; @if($transaction->transaction_sign==1) color:green; @else color:red; @endif">
                {{number_format($transaction->amount) . ($transaction->transaction_sign == 1 ? '+' : '-')}}
                تومان
            </h3>
        </div>
        <hr />
    @endforeach
    </div>
</div>
@endsection
