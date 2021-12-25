<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSentEvent;
use App\Models\Message;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use App\Models As Model;

class MessageController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function get()
    {
        return (new Model\Message())->getAllMessage();
    }

    public function send(Request $request)
    {
        // $user = Auth::user();
        $userId = Auth::id();
        $user = Model\User::find($userId);

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        event(new MessageSent($user, $message));

        return ['status' => 'Message Success!'];
    }
}