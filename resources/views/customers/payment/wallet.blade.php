@extends('layouts.customer', ['pageTitle' => 'کیف پول', 'withNavigation' => true])
@section('content')
<div style="margin:70px 0;">
    <div class="tab-container">
        <a href="{{route('customers.wallet')}}" id="products" class="tab-item selected">افزایش اعتبار</a>
        <a href="{{route('customers.transactions')}}" id="address" class="tab-item">تراکنش های من</a>
    </div>
</div>
@endsection
