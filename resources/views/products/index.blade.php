@extends('layouts.admin', ['pageTitle' => 'محصولات', 'newButton' => true, 'newButtonUrl' => 'products/create', 'newButtonText' => 'ایجاد محصول'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست محصولات</div>
        <div class="panel-body">
            @foreach($products as $product)
                <a class="col-sm-4" style="cursor: pointer;" href="{{route('products.edit', $product->id)}}">
                    <img src="{{$product->image_url}}" height="200" width="200" alt="{{$product->name}}">
                    <div style="color:white;margin-top:5px;">
                        {{$product->name}}
                        @if($product->is_active)
                            <span class="label label-success">{{config('enums.active.'.$product->is_active)}}</span>
                        @else
                            <span class="label label-default">{{config('enums.active.'.$product->is_active)}}</span>
                        @endif
                    </div>
                    <div style="color:white;margin-top:5px;">{{$product->description}}</div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
