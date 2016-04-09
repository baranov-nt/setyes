/**
 * Created by User on 09.04.2016.
 */
var http = require('http');
var fs = require('fs');

http.createServer(function(request, response) {
    fs.readFile('index.html', { encoding: 'utf8' }, function(error, file) {

    });
}).listen(80);