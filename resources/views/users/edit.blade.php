@extends('layouts.admin', ['pageTitle' => 'ایجاد کاربر', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش مشخصات کاربر</div>
        <div class="panel-body">
            {!! Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT')) !!}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">آدرس ایمیل</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">شماره موبایل (نام کاربری)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="mobile" minlength="11" maxlength="11" name="mobile" value="{{$user->mobile}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <button type="button" class="btn btn-primary" onclick="resetPassword('{{$user->id}}')">بازنشانی رمزعبور</button>
                        <a class="btn btn-default" href="{{route('users.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <script>
        function resetPassword(userId) {
            console.log(userId);
            $.ajax("{{route('users.resetPassword', $user->id)}}", {
                type: "get",
                success: function(response) {
                    swal(response.message);
                }
            })
        }
    </script>
@endsection
