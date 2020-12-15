@extends('layouts.admin', ['pageTitle' => 'ایجاد گروه محصول', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات محصول</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('availableProducts.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="gateway_id" class="col-lg-2 control-label">محصول</label>
                    <div class="col-lg-4">
                        {{Form::select('gateway_id', $products, null, ['name'=>'products', 'placeholder' => 'انتخاب محصول...', 'class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">قیمت پایه</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="price" name="price" value="{{old('price')}}" placeholder="قیمت پایه (تومان)" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="maximum_group_members" class="col-sm-2 control-label">حداکثر نفرات</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="maximum_group_members" name="maximum_group_members" value="{{old('maximum_group_members')}}" placeholder="حداکثر نفرات" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="quantity" class="col-sm-2 control-label">مجموع وزن</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}" placeholder="مجموع وزن">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('availableProducts.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
@endsection
