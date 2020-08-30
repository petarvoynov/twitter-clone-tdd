<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;

class MessagesController extends Controller
{
    public function show(User $user)
    {
        $mySendMessages = Message::where('from', auth()->id())->where('to', $user->id);
        $messages = Message::where('from', $user->id)->where('to', auth()->id())->union($mySendMessages)->orderBy('created_at', 'asc')->take(30)->get();

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(User $user)
    {
        auth()->user()->sendMessages()->create([
            'to' => $user->id,
            'message' => request('message')
        ]);

        return back()->with('success', 'You message has been send.');
    }
}
