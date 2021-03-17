@extends('layouts.admin', ['pageTitle' => 'ایجاد مدیر', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات مدیر</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('users.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">آدرس ایمیل</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">شماره موبایل (نام کاربری)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="mobile" minlength="11" maxlength="11" name="mobile" value="{{old('mobile')}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">رمزعبور</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="send_sms" class="col-sm-2 control-label">دریافت sms تائید</label>
                    <div class="col-sm-4">
                        {!! Form::select('send_sms', config('enums.yes_no'), 0, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('users.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
