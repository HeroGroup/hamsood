function disableButton() {
    if(document.getElementById("days")) {
        document.getElementById("days").innerHTML = "00";
        document.getElementById("hours").innerHTML = "00";
        document.getElementById("minutes").innerHTML = "00";
        document.getElementById("seconds").innerHTML = "00";
    }
    var hamsodButtons = document.getElementsByClassName("hamsood-btn");
    for(var i=0;i<hamsodButtons.length;i++) {
        hamsodButtons[i].innerHTML = "زمان سفارش گیری به اتمام رسید";
        hamsodButtons[i].disabled = true;
        hamsodButtons[i].style.backgroundColor = "lightgray";
        hamsodButtons[i].style.cursor = "not-allowed";
        hamsodButtons[i].style.fontSize = "10px";
    }
    var cartControlButtons = document.getElementsByClassName("add-subtract-button");
    for(var j=0;j<cartControlButtons.length;j++) {
        cartControlButtons[j].disabled = true;
        cartControlButtons[j].style.color = "gray";
        cartControlButtons[j].style.backgroundColor = "lightgray";
        cartControlButtons[j].style.cursor = "not-allowed";
    }
}

function countdown(distance) {
    if (distance > 0) {
        // Update the count down every 1 second
        var x = setInterval(function () {

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString();
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
            var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();

            // Display the result in associated elements
            document.getElementById("days").innerHTML = days.length > 1 ? days : "0" + days;
            document.getElementById("hours").innerHTML = hours.length > 1 ? hours : "0" + hours;
            document.getElementById("minutes").innerHTML = minutes.length > 1 ? minutes : "0" + minutes;
            document.getElementById("seconds").innerHTML = seconds.length > 1 ? seconds : "0" + seconds;

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                disableButton();
            }

            distance -= 1000;

        }, 1000);
    } else {
        disableButton();
    }
}

function addWeight(product, maximum, withUpdate=true) {
    var target = $(`#weight-${product}`);
    var weight = parseInt(target.text());
    if (weight === maximum) {
        // do nothing
    } else {
        target.text(weight+1);
        if (weight+1 > 1) {
            var targetButton = $(`#subtract-${product}`);
            targetButton.html("");
            targetButton.text('-');
        }
        if(withUpdate)
            $.ajax(`/order/increaseCartItem/${product}`, {
                type: "get",
                success: function (response) {
                    if (response.status < 0)
                        subtractWeight(product, false);
                }
            });
    }
}

function subtractWeight(product, withUpdate=true) {
    var target = $(`#weight-${product}`);
    var weight = parseInt(target.text());
    target.text(weight-1);
    var targetButton = $(`#subtract-${product}`);
    if (weight === 2) {
        // change icon to trash
        targetButton.html('<i class="fa fa-fw fa-trash-o"></i>');
    } else {
        // change text to -
        targetButton.html("");
        targetButton.text('-');
    }
    if(withUpdate)
        $.ajax(`/order/decreaseCartItem/${product}`, {
            type: "get",
            success: function (response) {
                if (response.status < 0) {
                    addWeight(product, 4, false);
                } else {
                    if (response.data === 0)
                        location.reload();
                }
            }
        });
}

const share = async (uid) => {
    const shareData = {
        title: 'همسود',
        text: 'شما هم در این خرید، همسود شوید',
        url: 'https://hamsod.com/suggestion/'+uid // 'https://survey.porsline.ir/s/gP5ZKVE/'
    };
    try {
        await navigator.share(shareData)
    } catch(err) {
        // resultPara.textContent = 'Error: ' + err
    }
};
