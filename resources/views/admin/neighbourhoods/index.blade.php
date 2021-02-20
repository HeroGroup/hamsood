@extends('layouts.admin', ['pageTitle' => 'لیست مناطق', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست مناطق</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>هزینه ها</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($neighbourhoods as $neighbourhood)
                        <tr>
                            <td>{{$neighbourhood->name}}</td>
                            <td>
                                <a href="{{route('neighbourhoodDeliveries.index', $neighbourhood->id)}}" class="btn btn-info btn-xs">ساعات و هزینه ارسال</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
