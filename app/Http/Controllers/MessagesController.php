<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;

class MessagesController extends Controller
{
    public function index()
    {
        $fromMe = Message::where('from', auth()->id())->pluck('to')->unique();

        $toMe = Message::where('to', auth()->id())->pluck('from')->unique();

        $usersId = $fromMe->merge($toMe)->unique();

        $users = User::find($usersId);

        return view('messages.index', compact('users'));
    }

    public function show(User $user)
    {
        // Getting all the messages that auth wrote to the given user
        $mySendMessages = Message::where('from', auth()->id())->where('to', $user->id);

        // Check if we clicked to load more messages (100) ~ else we take the last 30 messages
        if(request('more')){
            // We combine auth messages with the messages that the user wrote to the auth user and take the last 100 messages
            $messages = Message::where('from', $user->id)->where('to', auth()->id())->union($mySendMessages)->orderBy('created_at', 'asc')->take(100)->get();
        } else {
            // We combine auth messages with the messages that the user wrote to the auth user and take the last 30 messages
            $messages = Message::where('from', $user->id)->where('to', auth()->id())->union($mySendMessages)->orderBy('created_at', 'desc')->take(30)->get();

            // sorting it again so we can show it properly
            $messages = $messages->sortBy('created_at');
        }


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

    public function all(User $user)
    {
        $mySendMessages = Message::where('from', auth()->id())->where('to', $user->id);
        $messages = Message::where('from', $user->id)->where('to', auth()->id())->union($mySendMessages)->orderBy('created_at', 'asc')->paginate(20);

        return view('messages.all', compact('user', 'messages'));
    }
}
