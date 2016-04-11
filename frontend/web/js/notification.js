/**
 * Created by User on 07.04.2016.
 */
$( document ).ready(function() {
    var socket = io.connect('http://localhost:8890');
    socket.on('notification', function (data) {
        var message = JSON.parse(data);
        $("#chatBlock").show();
        $( "#notifications" ).prepend( "<p style='font-size: 11px;'><strong>" + message.name + "</strong>: " + message.message + "<br><strong><i style='font-size: 8px;'>(" + message.time + ")</i></strong></p>");
    });
});