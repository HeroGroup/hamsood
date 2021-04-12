<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <p style="margin-top:50px;text-align:center;">...لطفا چند لحطه صبر کنید</p>
    <form method="post" action="{{route('customers.pay')}}" id="pay-form">
        @csrf
        <input type="hidden" name="title" value="{{$title}}" />
        <input type="hidden" name="amount" value="{{$amount}}" />
        <input type="hidden" name="online_payment_method" value="{{$online_payment_method}}" />
        <input type="hidden" name="transaction_type" value="{{$transaction_type}}" />
        <input type="hidden" name="redirect" value="{{$redirect}}" />
    </form>
    <script>
        window.onload = (event) => {
            document.getElementById("pay-form").submit();
        };
    </script>
</body>
</html>
