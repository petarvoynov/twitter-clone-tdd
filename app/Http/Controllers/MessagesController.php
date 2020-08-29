<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;

class MessagesController extends Controller
{
    public function show()
    {
        
    }

    public function store(User $user)
    {
        Message::create([
            'from' => auth()->id(),
            'to' => $user->id,
            'message' => request('message')
        ]);
    }
}
