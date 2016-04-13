/**
 * Created by User on 07.04.2016.
 */
function play_single_sound() {
    document.getElementById('audiotag1').play();
}
$( document ).ready(function() {
    var socket = io.connect('http://185.20.225.204:8890');
    socket.on('notification', function (data) {
        var message = JSON.parse(data);
        if(document.hidden && (message.active == 1)) {
            play_single_sound();
        }
        $("#chatBlock").show();
        $( "#notifications" ).prepend( "<p style='font-size: 11px;'><strong>" + message.name + "</strong>: " + message.message + "<br><strong><i style='font-size: 8px;'>(" + message.time + ")</i></strong></p>");
    });
});