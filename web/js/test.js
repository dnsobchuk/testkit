$(document).ready(function () {
    var timer = setInterval(function () {
        var minutes = Number($("#minutes").text());
        var seconds = Number($("#seconds").text());
        seconds--;
        if (seconds < 0) {
            minutes--;
            seconds = 59;
            if (minutes < 0) {
                clearInterval(timer);
                minutes = seconds = 0;
            }
        }

        $("#minutes").text(("0" + minutes).slice(-2));
        $("#seconds").text(("0" + seconds).slice(-2));
    }, 1000);
});

history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};