@extends('layouts.admin', ['pageTitle' => 'لیست ساعات و هزینه ارسال منطقه '.$neighbourhood->name, 'newButton' => true, 'newButtonUrl' => 'create/'.$neighbourhood->id, 'newButtonText' => 'حذف لیست و ساخت از نو'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست ساعات و هزینه ارسال منطقه {{$neighbourhood->name}}</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ساعت شروع</th>
                        <th>ساعت پایان</th>
                        <th>هزینه ارسال</th>
                        <th>هزینه ارسال با تخفیف</th>
                        <td>ویرایش</td>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->delivery_start_time}}</td>
                            <td>{{$item->delivery_end_time}}</td>
                            <td>{{number_format(intval($item->delivery_fee))}}</td>
                            <td>{{$item->delivery_fee_for_now > 0 ? number_format(intval($item->delivery_fee_for_now)) : ($item->delivery_fee_for_now == null ? number_format(intval($item->delivery_fee)) : 'رایگان') }}</td>
                            <td>
                                <button class="btn btn-info btn-xs open-modal" onclick='openModal("{{$item->id}}")'>ویرایش</button>

                                <div id="custom-modal-{{$item->id}}" class="custom-modal">
                                    <div class="custom-modal-content">
                                        <span class="custom-close">&times;</span>
                                        <hr />
                                        {!! Form::model($item, array('route' => array('neighbourhoodDeliveries.update', $item), 'method' => 'PUT')) !!}
                                        @csrf
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="delivery_start_time" class="col-sm-4 control-label">ساعت شروع</label>
                                                <div class="col-sm-8">
                                                    {!! Form::select('delivery_start_time', config('enums.hours'), $item->delivery_start_time, array('class' => 'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="delivery_end_time" class="col-sm-4 control-label">ساعت پایان</label>
                                                <div class="col-sm-8">
                                                    {!! Form::select('delivery_end_time', config('enums.hours'), $item->delivery_end_time, array('class' => 'form-control', 'required' => 'required')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="delivery_fee" class="col-sm-4 control-label">هزینه ارسال</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="delivery_fee" value="{{$item->delivery_fee}}" class="form-control" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="delivery_fee_for_now" class="col-sm-4 control-label">هزینه ارسال با تخفیف</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="delivery_fee_for_now" value="{{$item->delivery_fee_for_now}}" class="form-control" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-success" style="width: 150px;">ذخیره</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </td>
                            @component('components.links')
                                @slot('itemId'){{$item->id}}@endslot
                                @slot('routeDelete'){{route('neighbourhoodDeliveries.destroy',$item->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
