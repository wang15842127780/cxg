var WebSocketServer = require('ws').Server;
var wss = new WebSocketServer({"http://47.104.93.214:8888"});
wss.on('connection',function(ws){
	console.log('client connected');
	ws.on('message',function(message){
		console.log('message');
	})
});
