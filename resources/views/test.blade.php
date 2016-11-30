@extends('layouts.master')

@section('content')
  <p id="power">0</p>
@stop

@section('footer')
  <script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
  <script>
    jQuery(function($){
      var socket = io('http://127.0.0.1:3000');
      socket.on("connection", function(data) {
        console.log("Mirko");
      });
      socket.on("test-channel:App\\Events\\EventName", function(message) {
        console.log(message);
        $("#power").text(parseInt($("#power").text()) + parseInt(message.data.power));
      });

    });
  </script>
@stop
