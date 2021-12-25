<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models As Model;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chatroom');
    }

    public function fetchMessages()
    {
        $responseData = new \stdClass();
        $responseData->chat_user_id = Auth::id();
        $responseData->chat_data = (new Model\Message())->getMessage()->sortBy('id')->values();
        return $responseData;
    }

    public function sendMessage(Request $request)
    {
        $user = Model\User::find(Auth::id());
        $message = $user->messages()->create([
            'message' => $request->message ?? ""
        ]);

        $messageData = new \stdClass();
        $messageData->id = $message->id;
        $messageData->user_id = $message->users_id;
        $messageData->user_name = $user->name;
        $messageData->message = $message->message;
        $messageData->created_at = (new \Datetime($message->created_at))->format('Y-m-d H:i:s');
        broadcast(new MessageSent($messageData));
        return ['status' => 'message sent success'];
    }
}