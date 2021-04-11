<div>
    @foreach(config('enums.online_payment_methods') as $key=>$method)
    @if($method['active'] == 1)
    <div style="border:1px solid lightgray;border-radius:5px;color:#222;padding:5px 10px;margin:20px 10px;@if($method['selected']) border-color:#31AC6B @endif">
        <input type="radio" id="{{$key}}" name="online_payment_method" value="{{$key}}" @if($method['selected']) checked @endif />
        &nbsp;
        <img src="{{$method['icon']}}" width="20" height="20">
        <label for="{{$key}}">{{$method['name']}}</label>
    </div>
    @endif
    @endforeach
</div>
<script>
    $("input[name=online_payment_method]").on("change", function() {
        $("input[type=radio]").parent().css({"border-color":"lightgray"});
        $(this).parent().css({"border-color":"#31AC6B"});
        if($("input[name=amount]").val() >= 1000)
            activateSubmitButton();
    });
</script>
