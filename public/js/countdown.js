function countdown(distance) {
    // Update the count down every 1 second
    var x = setInterval(function () {

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString();
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
        var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();

        // Display the result in associated elements
        document.getElementById("hours").innerHTML = hours.length > 1 ? hours : "0" + hours;
        document.getElementById("minutes").innerHTML = minutes.length > 1 ? minutes : "0" + minutes;
        document.getElementById("seconds").innerHTML = seconds.length > 1 ? seconds : "0" + seconds;

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
            document.getElementById("hamsood-btn").disabled = true;
            document.getElementById("hamsood-btn").style.backgroundColor = "lightgray";
            document.getElementById("hamsood-btn").style.cursor = "not-allowed";
        }

        distance -= 1000;

    }, 1000);
}
