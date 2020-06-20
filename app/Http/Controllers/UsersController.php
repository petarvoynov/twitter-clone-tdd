<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function follow(User $user)
    {
        if(auth()->user()->contains($user)){
            return back();
        }
        auth()->user()->follow($user);

        return back();
    }

    public function unfollow(User $user)
    {
        auth()->user()->unfollow($user);

        return back();
    }
}
