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
                        <tr>
                            <td @if($address->is_default) style="background-color:#99ff99;color:#222;" @endif>{{$address->neighbourhood->name . ' ' . $address->details}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
