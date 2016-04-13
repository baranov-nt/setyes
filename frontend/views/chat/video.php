<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.04.2016
 * Time: 17:36
 */
?>
<style type="text/css">
    #stream {
        height: 99%;
        margin: 0px auto;
        display: block;
        margin-top: 20px;
    }
</style>
<hr>
<script>
/*    var socket = io();
    socket.on('liveStream', function(url) {
        $('#stream').attr('src', url);
        $('.start').hide();
    });

    function startStream() {
        socket.emit('start-stream');
        $('.start').hide();
    }*/
</script>
<button type="button" id="" class="btn btn-info start" onclick="">Камера</button>

<div class="row">
    <img src="" id="stream">
</div>
