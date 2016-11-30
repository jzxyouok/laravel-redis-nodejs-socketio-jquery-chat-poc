<?php

namespace App;

use App\Chat;

class PrivateChat
{
    private $participants = array();

    public function __construct($participants = array())
    {
        sort($participants);
        $this->participants = $participants;
    }

    public function findChat()
    {
        $chat = \App\Chat::where('user_one', '=', $this->participants[0])->where('user_two', '=', $this->participants[1])->limit('10')
        ->first();
        return $chat;
    }

    public function createNewChat()
    {
        $chat = new \App\Chat();
        $chat->user_one = $this->participants[0];
        $chat->user_two = $this->participants[1];
        $chat->save();
        return $chat; 
    }

    public function chatExists()
    {
        $chat = \App\Chat::where('user_one', '=', $this->participants[0])->where('user_two', '=', $this->participants[1])
        ->first();
        if($chat === null)
            return false;

        return $chat;
    }

    public function getChatMessages($id)
    {
        $messages = \App\Message::where(array('chat_id'=>$id))->get();
        return $messages;
    }

    public function saveNewMessage($chat, $content,$user)
    {
        $message = new \App\Message();
        $message->content = $content;
        //$message_chat_id = $message->chat_id;
        //$chat_id = $chat->id;
        //$message->chat_id = $chat->id;
        //$message->save();
        return $message;
    }

    public function getParticipants()
    {
        return $this->participants;
    }
}


