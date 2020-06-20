<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function follow(User $user)
    {
        if(!auth()->user()->followings->contains($user)){
            auth()->user()->follow($user);
        }
        
        return back();
    }

    public function unfollow(User $user)
    {
        if(!auth()->user()->followings->contains($user)){
            abort(403);
        }

        auth()->user()->unfollow($user);
        
        return;
    }
}
