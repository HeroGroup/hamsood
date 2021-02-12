@extends('layouts.admin', ['pageTitle' => 'لیست مناطق', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست مناطق</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>نام</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($neighbourhoods as $neighbourhood)
                        <tr>
                            <td>{{$neighbourhood->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
