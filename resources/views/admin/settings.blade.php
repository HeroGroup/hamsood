@extends('layouts.admin', ['pageTitle' => 'Settings', 'newButton' => false])
@section('content')
<div class="form-horizontal">
    <div class="form-group">
        <form method="post" action="{{route('settings.post')}}">
            @csrf
            <input type="hidden" name="id" value="{{$setting->id}}" />
            <label for="hours_working" class="col-sm-2 control-label">Hours Working</label>
            <div class="col-sm-2">
                <input type="number" name="hours_working" value="{{$setting->hours_working}}" class="form-control" style="font-size:20px;text-align:center;" />
            </div>
            <div class="col-sm-2">
                <input type="submit" name="'submit'" class="btn" style="color:#222" />
            </div>
        </form>
    </div>
</div>
@endsection
