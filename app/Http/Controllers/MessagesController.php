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
        auth()->user()->sendMessages()->create([
            'to' => $user->id,
            'message' => request('message')
        ]);
    }
}
