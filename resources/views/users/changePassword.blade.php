@extends('layouts.admin', ['pageTitle' => $user->name, 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تغییر رمز عبور</div>
        <div class="panel-body">
            <form method="post" action="{{route('users.updatePassword')}}">
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="old_password" class="col-sm-2 control-label">رمز عبور فعلی</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">رمز عبور جدید</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">تکرار رمز عبور جدید</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
