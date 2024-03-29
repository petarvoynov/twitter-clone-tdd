<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;

class MessagesController extends Controller
{
    public function index()
    {
        // Getting the users ID that i had send messages to
        $fromMe = Message::where('from', auth()->id())->pluck('to')->unique();

        // Getting the users ID that they send messages to me
        $toMe = Message::where('to', auth()->id())->pluck('from')->unique();

        // Merge them in one collection
        $usersId = $fromMe->merge($toMe)->unique();

        $users = User::findOrFail($usersId);

        // Adding last_message field containing the timestamp for the last message betweets the auth and the user so we can sort the chats 
        $users = $users->map(function($user){
            $user->last_message = auth()->user()->lastMessage($user)->created_at->toDateTimeString();
            return $user;
        })->sortByDesc('last_message')
            ->paginate(15);

        return view('messages.index', compact('users'));
    }

    public function show(User $user)
    {
        if(auth()->id() == $user->id) return redirect()->route('messages.index')->with('warning', 'You cannot chat with yourself');

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

        if($messages->where('from', $user->id)->last()){
            $messages->where('from', $user->id)->last()->update(['read_at' => now()]);
        }
        
        return view('messages.show', compact('user', 'messages'));
    }

    public function store(User $user)
    {     
        if(auth()->id() == $user->id) return redirect()->route('messages.index')->with('warning', 'You cannot chat with yourself');

        request()->validate([
            'message' => 'required'
        ]);
        
        if(!$user->isFollowing(auth()->user()) && $user->message_settings != 'everyone' ){
            return back()->with('warning', $user->name . ' has his privacy chat settings "on" and only people that he follows can message him.');
        }

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
