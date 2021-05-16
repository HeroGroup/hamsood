@extends('layouts.admin', ['pageTitle' => 'مناطق تحت پوشش', 'newButton' => false])
@section('content')
    <div>
        <button class="btn btn-primary" onclick='openModal("create")'>
            <i class="fa fa-fw fa-plus"></i> منطقه جدید
        </button>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">مناطق تحت پوشش</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>منطقه</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($areas as $area)
                        <tr>
                            <td>{{$area->id}}</td>
                            <td>{{$area->supporting_area}}</td>
                            <td>
                                <button class="btn btn-info btn-xs open-modal" onclick='openModal("{{$area->id}}")'>ویرایش</button>

                                <div id="custom-modal-{{$area->id}}" class="custom-modal">
                                    <div class="custom-modal-content">
                                        <span class="custom-close">&times;</span>
                                        <h4>ویرایش منطقه</h4>
                                        <hr />
                                        {!! Form::model($area, array('route' => array('settings.supportingAreas.update', $area), 'method' => 'PUT')) !!}
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="supporting_area" class="col-sm-2 control-label">عنوان منطقه</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="supporting_area" value="{{$area->supporting_area}}" class="form-control" required />
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
                                @slot('itemId'){{$area->id}}@endslot
                                @slot('routeDelete'){{route('settings.supportingAreas.remove',$area->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="custom-modal-create" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <h4>منطقه جدید</h4>
            <hr />
            <form method="post" action="{{route('settings.supportingAreas.store')}}">
                @csrf
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="supporting_area" class="col-sm-2 control-label">عنوان منطقه</label>
                        <div class="col-sm-10">
                            <input type="text" name="supporting_area" class="form-control" required />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" style="width: 150px;">ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
