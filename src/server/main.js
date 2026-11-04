var http = require('http');
const fs = require('fs');
http.createServer(function (req,res) {
    fs.readFile("../user/index.html", function(err,data) {
        if (err) {
            res.writeHead(500,{'Content-Type': 'text/plain'});
            res.end("Content not found");
        } else {
            res.writeHead(200,{'Content-Type': 'html'});
            res.end(data);
        }
    });
}).listen(80);