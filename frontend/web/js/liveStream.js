/**
 * Created by User on 13.04.2016.
 */
$( document ).ready(function() {
    var socket = io.connect('http://185.20.225.204:3000');
    socket.on('liveStream', function(url) {
        $('#stream').attr('src', url);
        $('.start').hide();
    });

    function startStream() {
        socket.emit('start-stream');
        $('.start').hide();
    }

    startStream();
});



