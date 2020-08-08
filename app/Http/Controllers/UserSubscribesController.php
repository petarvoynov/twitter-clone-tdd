<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserSubscribesController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->subscribe($user);

        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->unsubscribe($user);

        return back();
    }
}
