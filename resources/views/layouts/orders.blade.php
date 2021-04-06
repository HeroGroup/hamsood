@extends('layouts.customer', ['pageTitle' => 'لیست سفارشات', 'withNavigation' => true, 'backUrl' => '/'])
@section('content')

@include('layouts.bottomMenu')

    <style>
        .badge-number {
            border-radius:50%;color:white;width:20px;text-align:center;position: absolute;left:0;
        }
        a {
            position: relative;
        }
    </style>
    <div style="margin:70px 0;">
        <div class="tab-container">
            <a href="#" onclick="changeTab('{{route('customers.orders.current')}}')" id="current" class="tab-item @if($selected=='current') selected border-color-yellow @endif">
                جاری
                @if($selected=='current')
                    <label class="badge-number" style="background-color:#ffcc00;">{{$orders->count()}}</label>
                @endif
            </a>
            <a href="#" onclick="changeTab('{{route('customers.orders.success')}}')" id="success" class="tab-item @if($selected=='success') selected @endif">
                موفق
                @if($selected=='success')
                    <label class="badge-number" style="background-color:#31AC6B;">{{$orders->count()}}</label>
                @endif
            </a>
            <a href="#" onclick="changeTab('{{route('customers.orders.failed')}}')" id="failed" class="tab-item @if($selected=='failed') selected border-color-red @endif">
                لغو شده
                @if($selected=='failed')
                    <label class="badge-number" style="background-color:red;">{{$orders->count()}}</label>
                @endif
            </a>
        </div>

        @yield('tab-content')
    </div>

    @component('components.loader')@endcomponent

    <script>
        function changeTab(url) {
            event.preventDefault();
            turnOnLoader();
            window.location.href = url;
        }
    </script>
@endsection
