@extends('layouts.customer', ['pageTitle' => 'صورتحساب', 'withNavigation' => true])
@section('content')
<div style="margin:70px 0;">
    <div style="margin:0 10px;">
    <form method="post" action="{{route('customers.confirmBill')}}" id="bill-form">
    @csrf
    <input type="hidden" name="paymentAmount" value="{{$prices['yourPayment']}}" />
    @component('components.orderBill', [
        'realPrice' => $prices['realPrice'],
        'yourPrice' => $prices['yourPrice'],
        'shippmentPrice' => $prices['shippmentPrice'],
        'shippmentPriceForNow' => $prices['shippmentPriceForNow'],
        'yourProfit' => $prices['yourProfit'],
        'yourPayment' => $prices['yourPayment']
    ])@endcomponent
    </form>
    </div>
</div>

<div style="position:fixed;bottom:0;left:0;width:100%;background-color:white;">
    <button type="button" class="btn confirm-button" onclick="submit()" id="submit-button">
        تايید
    </button>
</div>
<script>
    function submit() {
        $("#submit-button").prop("disabled",true);
        document.getElementById("bill-form").submit();
    }
</script>

@endsection
