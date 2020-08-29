<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserSubscribesController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->subscribe($user);

        return back()->with('success', 'You successfully subscribed to '. $user->name .'.');;
    }

    public function destroy(User $user)
    {
        auth()->user()->unsubscribe($user);

        return back()->with('success', 'You successfully unsubscribed from '. $user->name .'.');;
    }
}
