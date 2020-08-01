<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities->paginate(15);

        return view('users.show', compact(['user', 'activities']));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $validatedData = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'location' => 'nullable'
        ]);
    
        $user->update($validatedData);

        return redirect()->route('users.show', ['user' => $user->id]);
    }

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
        
        return back();
    }
}
