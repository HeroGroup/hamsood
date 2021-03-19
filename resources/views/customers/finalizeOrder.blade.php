@extends('layouts.customer', ['pageTitle' => 'صورتحساب', 'withNavigation' => true])
@section('content')

<div style="position:fixed;bottom:0;left:0;width:100%;">
    <a class="btn confirm-button" href="{{route('customers.finalizeOrder')}}">
        ثبت نهایی
    </a>
</div>
@endsection
