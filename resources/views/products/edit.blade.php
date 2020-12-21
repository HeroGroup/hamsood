@extends('layouts.admin', ['pageTitle' => 'مشاهده محصول', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات محصول</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('products.update', $product), 'method' => 'PUT', 'files' => 'true')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام محصول</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">توضیحات</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="description" name="description" value="{{$product->description}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="base_price_url" class="col-sm-2 control-label">لینک خرید عادی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="base_price_url" name="base_price_url" value="{{$product->base_price_url}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_active" class="col-sm-2 control-label">توضیحات</label>
                    <div class="col-sm-4">
                        <span> فعال </span>
                        <label class="switch">
                            <input type="checkbox" name="is_active" @if($product->is_active == 1) checked @endif >
                            <span class="slider round"></span>
                        </label>
                        <span> غیرفعال </span>
                    </div>
                </div>
                <image src="{{$product->image_url}}" alt="{{$product->name}}" />
                <div class="form-group">
                    <label class="col-sm-2 control-label">عکس محصول:</label>
                    <div class="col-sm-4">
                        <input name="image_file" type="file" accept="image/*" placeholder="یک عکس انتخاب کنید" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('products.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
