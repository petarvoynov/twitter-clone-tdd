<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities->paginate(15);

        $followedBy = $user->followers->take(3)->implode('name', ', ');

        return view('users.show', compact(['user', 'activities', 'followedBy']));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update()
    {
        $validatedData = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'location' => 'nullable',
            'message_settings' => ''
        ]);
    
        auth()->user()->update($validatedData);

        return redirect()->route('users.show', ['user' => auth()->id()])->with('success', 'You successfully updated your profile.');
    }

    public function follow(User $user)
    {
        if(!auth()->user()->followings->contains($user)){
            auth()->user()->follow($user);
        }
        
        return back()->with('success', 'You successfully followed '. $user->name .'.');
    }

    public function unfollow(User $user)
    {
        if(!auth()->user()->followings->contains($user)){
            abort(403);
        }

        if(auth()->user()->isSubscribedTo($user)){
            auth()->user()->unsubscribe($user);
        }

        auth()->user()->unfollow($user);
        
        return back()->with('success', 'You successfully unfollowed '. $user->name .'.');
    }

    public function find()
    {
        $searchName = request('name');

        $users = User::where('id', '!=', auth()->id())->where('name', 'like', '%'. $searchName .'%')->paginate(10);

        return view('users.find', compact('users', 'searchName'));
    }
}
