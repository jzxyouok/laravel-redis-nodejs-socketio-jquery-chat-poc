var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis(6379, '127.0.0.1');

redis.psubscribe('*', function(err, count) {
  if(err) throw err;
  console.log("count: ");
  console.log(count);
});

redis.on('pmessage', function(pattern, channel, message) {
  console.log(channel + ':' + message.event);
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data);
});

redis.on('error', function(err) {
    if(err) throw err;
    console.log("Redis is not running");
});

redis.on('ready', function(){
    console.log("Redis is running");
});

http.listen(3000, function(){
  console.log('Listening on PORT 3000');
});
