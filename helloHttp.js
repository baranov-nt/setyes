/**
 * Created by User on 09.04.2016.
 */
var http = require("http");

function start() {
    function onRequest(request, response) {
        console.log("Request received.");
        response.writeHead(200, {"Content-Type": "text/plain"});
        response.write("Hello World");
        response.end();
    }

    http.createServer(onRequest).listen(8080);
    console.log("Server has started.");
}

function testConsole() {
    console.log("Server has tested.");
}

exports.start = start;
exports.testConsole = testConsole;
