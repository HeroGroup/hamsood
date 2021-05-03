@extends('layouts.admin', ['pageTitle' => 'پروفایل '.$user->name, 'newButton' => false])
@section('content')
  <div class="row">
    <div class="col-lg-6">
      <div class="panel panel-default">
          <div class="panel-heading">ویرایش مشخصات</div>
          <div class="panel-body">
            {!! Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT')) !!}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">نام</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">آدرس ایمیل</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-4 control-label">شماره موبایل</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="mobile" minlength="11" maxlength="11" name="mobile" value="{{$user->mobile}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-left">
                        <button type="button" class="btn btn-primary" onclick="resetPassword('{{$user->id}}')">بازنشانی رمزعبور</button>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
          </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="panel panel-default">
          <div class="panel-heading">تغییر رمز عبور</div>
          <div class="panel-body">
              <form method="post" action="{{route('users.updatePassword')}}">
              @csrf
              <div class="form-horizontal">
                  <div class="form-group">
                      <label for="old_password" class="col-sm-4 control-label">رمز عبور فعلی</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="old_password" name="old_password" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="password" class="col-sm-4 control-label">رمز عبور جدید</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password" name="password" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="password_confirmation" class="col-sm-4 control-label">تکرار رمز عبور جدید</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-sm-12 text-left">
                          <button type="submit" class="btn btn-success">ذخیره</button>
                      </div>
                  </div>
              </div>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
