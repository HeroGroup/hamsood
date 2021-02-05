@extends('layouts.customer', ['pageTitle' => 'آدرس محل دریافت کالا', 'withNavigation' => true])
@section('content')
<style>
.checked {
    float:left;
    margin-left:10px;
}
</style>
<div class="dark-overlay">
    <div class="overlay-container">
        <span style="font-size:22px;">انتخاب محله</span>
        <img src="/images/search_icon.png" width="25" height="25" style="float:left;cursor:pointer;" />
        <div style="margin-top:10px" id="search-container">
            <input type="text" placeholder="جستجو ..." class="form-control" onkeyup="getNeighbourhoods(this.value);" />
        </div>
        <div id="neighbourhoods-list" style="margin-top:10px;margin-bottom:60px;padding:0 10px;"></div>
        <div style="padding:25px 40px;;background-color:white;position:fixed;bottom:0;left:0;width:100%;z-index:6;display:flex;justify-content:space-between;">
            <a class="btn inactive" href="#" style="width:100px;" id="confirm-button">تائید</a>
            <button class="btn" onclick="event.preventDefault(); window.history.back();" style="width:100px;color:#222;background-color:white;">انصراف</a>
        </div>
    </div>
</div>

<script>
    var selected = 0;
    $(document).ready(function() {
        if (selected > 0) {
            activateConfirmButton();
        } else {
            disableConfirmButton();
        }

        getNeighbourhoods();
    });

    function activateConfirmButton() {
        $("#confirm-button").removeClass("inactive").addClass("active");
        $("#confirm-button").attr("href","postNeighbourhood/"+selected);
    }

    function disableConfirmButton() {
        selected = 0;
        $("#confirm-button").removeClass("active").addClass("inactive");
        $("#confirm-button").attr("href","#");
    }

    function getNeighbourhoods(word=null) {
        var url = word ? `/getNeighbourhoods/1/${word}` : `/getNeighbourhoods/1`;
        $.ajax(url, {
            method:"get",
            success:function(response) {
                result = "";
                for(var i=0;i<response.length;i++) {
                    result += `<p id='${response[i].id}' style="cursor:pointer;" onclick='checkItem(this.id)'>${response[i].name} `;

                    if (response[i].id == selected)
                        result += `<img src='/images/checked_icon.png' width='20' height='20' class='checked' />`;

                    result += `</p><hr style='margin:8px 0;' />`;
                }

                $("#neighbourhoods-list").html(result);
            }
        });
    }

    function checkItem(itemId) {
        if (selected !== itemId) {
            $('.checked').remove();
            selected = itemId;
            $(`#${itemId}`).append(`<img src='/images/checked_icon.png' width='20' height='20' class='checked' />`);
            activateConfirmButton();
        }
    }
</script>
@endsection
