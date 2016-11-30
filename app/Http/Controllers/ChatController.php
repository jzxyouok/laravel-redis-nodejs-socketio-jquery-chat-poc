<?php

namespace App\Http\Controllers;

use Sentinel;
use Illuminate\Http\Request;
use App\PrivateChat;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    /* Display list of users and chat area */
    public function index(Request $request)
    {
        $users = \App\User::where('email', '!=', Sentinel::getUser()->email)->get();
        return view('centaur.chat', ['users' => $users]); 
    }

    public function openChat(Request $request)
    {
        $user_one = Sentinel::getUser()->id;
        $user_two = (int)$request->get('with_user');
        $chitchat = new PrivateChat([$user_one, $user_two]);
        $chat = $chitchat->chatExists();
        if($chat === false) {
            $chat = $chitchat->createNewChat();
            return response()->json(['chat_id'=>$chat->id]);
        }
        $chat_history = $chitchat->getChatMessages($chat->id);
        return response()->json([
            'chat_id' => $chat->id,
            'current_user' => $user_one,
            'other_user' => $user_two,
            'chat_history' => $chat_history,
        ]);
    }

    /* Send chat message end point message */
    public function send(Request $request)
    {
        $user_one = Sentinel::getUser()->id;
        $user_two = (int)$request->get('user');
        $usr_arr = [$user_one, $user_two];
        sort($usr_arr);
        $chat = DB::select('select * from chats where user_one = ? and user_two = ?', [$usr_arr[0], $usr_arr[1]]);
        $message = new \App\Message();
        $message->content = $request->get('content');
        $message->user_id = $user_one;
        $message->chat_id = $chat[0]->id;
        $message->save();
        $chat = \App\Chat::find($chat[0]->id);
        event(new \App\Events\NewMessage(\App\User::find($user_one),$chat, $message)); 

        return response()->json(['message'=>$message]);
    }

    public function allChats(Request $request)
    {
        $user = Sentinel::getUser()->id;
        $chats = DB::select('select * from chats where user_one = ? or user_two = ?', [$user, $user]);
        return response()->json($chats);
    }

    public function upload(Request $request)
    {
        $fileUploadHelper = new \App\FileUploadHelper($_FILES, Sentinel::getUser(), $request->get('other_user'));
        if(!$fileUploadHelper->validate())
            die("NOT VALIDATED");

        $fileUploadHelper->saveFile();
        return json_encode(array("success"));
 
    }
}
