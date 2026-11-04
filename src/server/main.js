var https = require('https');
const fs = require('fs');
https.createServer(function (req,res) {
    fs.readFile("..../user/index.html", function(err,data) {
        if (err) {
            res.writeHead(404,{'Content-Type': 'text/plain'});
            res.end("Content not found or something.")
        } else {
            res.writeHead(404,{'Content-Type': 'text/html'});
            res.end(data);
        }
    });
}).listen(80);