/**
 * Created by User on 09.04.2016.
 */
/*
var http = require('http');
var server = http.createServer(function(req, res) {
    res.writeHead(200);
    res.end('Hello Http');
});

server.listen(8080);*/
var http = require('http');

var server = http.createServer(function(request, response) {
    // magic happens here!
});
server.listen(8080);
/*var express = require('express');
var app = express();

app.get('/', function (req, res) {
    res.send('Hello World!');
});*/
