@extends('layouts.admin', ['pageTitle' => 'ایجاد گروه محصول', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مراحل تخفیف محصول</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('availableProducts.storeDetails'), 'method' => 'POST')) }}
            @csrf
            <input type="hidden" name="available_product_id" value="{{$newProduct->id}}" />
            <div class="form-horizontal">
            @for($i=1;$i<$newProduct->maximum_group_members;$i++)
                <div class="form-group">
                    <label for="gateway_id" class="col-lg-3 control-label">تخفیف مرحله {{$i}} (درصد)</label>
                    <div class="col-lg-2">
                        <input type="number" class="form-control" id="levels[{{$i}}]" name="levels[{{$i}}]" value="{{$defaultDiscounts[$i]}}" required>
                    </div>
                </div>
            @endfor
                <div class="form-group">
                    <div class="col-sm-5 text-left">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
