<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function follow(User $user)
    {
        auth()->user()->followings()->attach($user->id);

        return back();
    }
}
