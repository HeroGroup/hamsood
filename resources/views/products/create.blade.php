@extends('layouts.admin', ['pageTitle' => 'ایجاد محصول', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات محصول</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('products.store'), 'method' => 'POST', 'files' => 'true')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام محصول</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">توضیحات</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="description" name="description" value="{{old('description')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="base_price_url" class="col-sm-2 control-label">لینک خرید عادی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="base_price_url" name="base_price_url" value="{{old('base_price_url')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">عکس محصول</label>
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
