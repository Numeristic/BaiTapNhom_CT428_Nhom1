var https = require('https');
https.createServer(function (req,res) {
    res.writeHead(200,{'Content-Type': 'text/html'});
    res.end('Test');
}).listen(80);