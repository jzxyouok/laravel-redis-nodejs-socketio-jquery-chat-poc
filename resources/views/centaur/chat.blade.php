@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <h4>Current user: {{ Sentinel::getUser()->email }}</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <ul class="list-group">
        @foreach ($users as $user)
            <li class="list-group-item"><button class="people" data-id="{{$user->id}}" data-email="{{$user->email}}">{{ $user->email }}</button></li>
        @endforeach
      </ul>
    </div>
    <!--<div class="col-md-3">-->
    <div>
      <div id="chat-space">
        <input type="hidden" value="" id="other_user_email"/>
        <input type="hidden" value="{{ Sentinel::getUser()->id }}" id="current_user_id" />
        
        <section class="messages">
          <div class="chat-header"><b><span id="private-chat-with"></span></b></div>
          <div id="messages"></div>
          <div id="send-message-section"></div>
        </section>
      </div>
    </div>
  </div>
<div>

@stop
