function saveRow(gatewayId,csrf) {
    var save_button = $(`#${gatewayId}_save`),
        max_current = $(`#${gatewayId}_max_current`),
        minutes_after = $(`#${gatewayId}_minutes_after`),
        off_minutes = $(`#${gatewayId}_off_minutes`);

    save_button.html("<img src='/images/loading-icon.gif' width='54' height='26' />");
    save_button.prop("disabled", true);

    $.ajax("/admin/gateways/patterns/store", {
        type: "post",
        data: {
            _token: csrf,
            gateway_id: gatewayId,
            max_current: max_current.val(),
            minutes_after: minutes_after.val(),
            off_minutes: off_minutes.val()
        },
        success: function (response) {
            console.log(response);
        }
    });

    setTimeout(function() {
        save_button.html("<i class=\"fa fa-save\"></i> ذخیره");
        save_button.prop("disabled", false);
    }, 2000);
}
