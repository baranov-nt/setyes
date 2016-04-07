/**
 * Created by User on 07.04.2016.
 */
$( document ).ready(function() {

    var socket = io.connect('http://localhost:8890');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);

        $( "#notifications" ).prepend( "<p><strong>" + message.name + "</strong>: " + message.message + "</p>" );

    });

});