@extends('layouts.admin', ['pageTitle' => 'کاربران', 'newButton' => true, 'newButtonUrl' => 'users/create', 'newButtonText' => 'ایجاد کاربر'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">کاربران</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>شماره موبایل</th>
                        <th>آدرس ایمیل</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($user->created_at))}}</td>
                            @component('components.links')
                                @slot('routeEdit'){{route('users.edit',$user->id)}}@endslot
                                @slot('itemId'){{$user->id}}@endslot
                                @slot('routeDelete'){{route('users.destroy',$user->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
