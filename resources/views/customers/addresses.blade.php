@extends('layouts.customer', ['pageTitle' => 'آدرس محل دریافت کالا', 'withNavigation' => true])
@section('content')
    <div style="text-align:center;">
    @if(count($addresses) > 0)
        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <button class="btn confirm-button">
                تائید آدرس
            </button>
        </div>
    @else
        <div style="text-align:center;margin-top:100px;color:#222;">
            <img src="/images/new_address.png" width="120" height="120" />
            <div style="margin-top:50px;">
                <p>آدرس محل تحویل کالا را با کلیک بر روی</p>
                <p>دکمه <b>ثبت آدرس جدید</b> ثبت کنید</p>
            </div>
        </div>

        <div style="position:fixed;bottom:0;left:0;width:100%;">
            <button class="btn confirm-button" disabled style="background-color:lightgray;color:darkgray;">
                تائید آدرس
            </button>
        </div>
    @endif

        <div class="dashed-button-container">
            <a href="{{route('customer.selectNeighbourhood')}}" class="dashed-button">ثبت آدرس جدید</a>
        </div>
    </div>


@endsection
