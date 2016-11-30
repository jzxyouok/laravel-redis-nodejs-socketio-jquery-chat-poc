<?php

namespace App;

class FileUploadHelper
{

    private $file = array();
    private $message;
    private $chat;
    private $current_user;
    private $other_user_id;
    private $new_file_name;

    public function __construct($file = array(), $user, $other_u_id)
    {
        $this->file = $file;
        $this->current_user = $user;
        $this->other_user_id = $other_u_id;
    }

    public function validate()
    {
        return true;
    }

    public function saveFile()
    {
        $path = public_path('files');
        $filename = $this->file['file']['name'].time();
        $tmp_path = $this->file['file']['tmp_name'];
        if(!move_uploaded_file($tmp_path, "$path/$filename"))
            return false;

        $this->new_file_name = "/files/".$filename;
        $this->saveMessage();   
        
    }

    private function saveMessage()
    {
        $tmp_arr = [$this->current_user->id, $this->other_user_id];
        sort($tmp_arr);
        $chat = \App\Chat::where('user_one', '=', $tmp_arr[0])->where('user_two', '=', $tmp_arr[1])->first();
        $message = new \App\Message();
        $message->content = "<a href=".$this->new_file_name.">".$this->file['file']['name']."</a>";
        $message->user_id = $this->current_user->id;
        $message->chat_id = $chat->id;
        $message->save();
        
        event(new \App\Events\NewMessage($this->current_user,$chat, $message)); 
    }

    private function activateEvent()
    {
        
    }

    public function getFile()
    {
        return $this->file;
    }
}
