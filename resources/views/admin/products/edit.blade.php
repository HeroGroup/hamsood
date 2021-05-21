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
                        <textarea id="description" name="description" class="form-control" rows="3">{{$product->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="categories" class="col-sm-2 control-label">دسته بندی</label>
                    <div class="col-sm-4">
                    <select name="categories[]" multiple class="form-control">
                        @foreach($categories as $key=>$category)
                            <option value="{{$key}}" @if(in_array($key, $allocatedCategories, true)) selected="selected" @endif>{{$category}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_active" class="col-sm-2 control-label">وضعیت</label>
                    <div class="col-sm-4">
                        <span> فعال </span>
                        <label class="switch">
                            <input type="checkbox" name="is_active" @if($product->is_active == 1) checked @endif >
                            <span class="slider round"></span>
                        </label>
                        <span> غیرفعال </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">عکس محصول:</label>
                    <div class="col-sm-4">
                        <input name="image_file" type="file" accept="image/*" placeholder="یک عکس انتخاب کنید" >
                        <image src="{{$product->image_url}}" alt="{{$product->name}}" style="width:100%;" />
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
