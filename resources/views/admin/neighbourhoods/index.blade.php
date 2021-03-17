@extends('layouts.admin', ['pageTitle' => 'لیست مناطق', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست مناطق</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>شهر</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($neighbourhoods as $neighbourhood)
                        <tr>
                            <td>{{$neighbourhood->city->name}}</td>
                            <td>{{$neighbourhood->name}}</td>
                            <td>
                                <a href="{{route('neighbourhoodDeliveries.index', $neighbourhood->id)}}" class="btn btn-info btn-xs">ساعات و هزینه ارسال</a>
                                <button id="btn-{{$neighbourhood->id}}" onclick="toggleActivation('{{$neighbourhood->id}}')" class="btn @if($neighbourhood->is_active) btn-danger @else btn-success @endif btn-xs">
                                    @if($neighbourhood->is_active) غیرفعالسازی @else فعالسازی @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function toggleActivation(id) {
            $.ajax("/admin/toggleActivateNeighbourhood/"+id, {
                success: function(response) {
                    if (response.status) {
                        var target = $(`#btn-${id}`);
                        if(response.data.is_active === 1) {
                            target.removeClass("btn-success").addClass("btn-danger");
                            target.html("غیرفعالسازی");
                        } else {
                            target.removeClass("btn-danger").addClass("btn-success");
                            target.html("فعالسازی");
                        }
                    } else {
                        swal(response.message);
                    }
                }
            });
        }
    </script>
@endsection
