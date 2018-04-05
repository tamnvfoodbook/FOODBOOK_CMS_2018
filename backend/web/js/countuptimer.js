/**
 * Created by Administrator on 10/2/2015.
 */
$('.countup').each(function () {
    var targetdate = $(this).children("#targetdate").html();
    var seconds_left = new Date(targetdate).getTime();
    var timer = $(this).children('#timer');
    var minutes, seconds;

    seconds_left = seconds_left / 1000;

    var countdownrefesh = setInterval(function () {
        // Add one to seconds
        seconds_left = seconds_left + 1;

        // do some time calculations
        days = parseInt(seconds_left / 86400);
        seconds_left = seconds_left % 86400;

        hours = parseInt(seconds_left / 3600);
        seconds_left = seconds_left % 3600;

        minutes = parseInt(seconds_left / 60);
        seconds = parseInt(seconds_left % 60);

        // format countdown string + set tag value
        t = hours + "h:" + minutes + "m:" + seconds + "s";
        timer.html(t)

    }, 1000);
});