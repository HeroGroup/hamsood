@extends('layouts.admin', ['pageTitle' => 'لیست آدرس ها '.(count($addresses) > 0 ? $addresses[0]->customer->name : ""), 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست آدرس ها {{count($addresses) > 0 ? $addresses[0]->customer->name : ""}}</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>آدرس</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($addresses as $address)
                        <tr @if($address->is_default) class="text-success" @endif>
                            <td>{{$address->neighbourhood->name . ' ' . $address->details}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
