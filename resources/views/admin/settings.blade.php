<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>تنظیمات</title>
    <meta name='robots' content='noindex, nofollow' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
</head>
<body>
    <div style="margin:30px;">
        <label>Last Update: </label><span>{{$setting->updated_at}}</span>
        <hr />
        <form method="post" action="{{route('settings.post')}}">
            @csrf
            <input type="hidden" name="id" value="{{$setting->id}}" />
            <label for="hours_working">Hours Working</label>
            <div>
                <input type="number" name="hours_working" value="{{$setting->hours_working}}" style="font-size:28px;text-align:center;width:100px;" />
                &nbsp;
                <input type="submit" name="'submit'" class="btn" style="color:#222;font-size:28px;" />
            </div>

        </form>
    </div>
</body>
</html>
