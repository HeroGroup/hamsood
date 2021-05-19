@extends('layouts.admin', ['pageTitle' => 'محصولات', 'newButton' => true, 'newButtonUrl' => 'products/create', 'newButtonText' => 'ایجاد محصول'])
@section('content')
    <style>
        .description {
            color:gray;
            margin-top:5px;
            overflow:hidden;
            text-overflow:ellipsis;
            display:-webkit-box;
            -webkit-line-clamp:1;
            -webkit-box-orient:vertical;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">لیست محصولات</div>
        <div class="panel-body">
            @foreach($products as $product)
                <a class="col-sm-3" style="text-decoration:none;cursor: pointer;margin-bottom:20px;" href="{{route('products.edit', $product->id)}}">
                    <img src="{{$product->image_url}}" height="200" width="200" alt="{{$product->name}}">
                    <div style="color:white;margin-top:5px;">
                        {{$product->name}}
                        @if($product->is_active)
                            <span class="label label-success">{{config('enums.active.'.$product->is_active)}}</span>
                        @else
                            <span class="label label-default">{{config('enums.active.'.$product->is_active)}}</span>
                        @endif
                    </div>
                    <div class="description">{{$product->description ?? 'فاقد توضیحات'}}</div>
                </a>

            @endforeach
        </div>
    </div>
@endsection
