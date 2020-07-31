<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfilePictureController extends Controller
{
    public function store()
    {
        request()->validate([
            'profile_picture' => 'required|image'
        ]);
        
        auth()->user()->update([
            'profile_picture' => request()->file('profile_picture')->store('profile_pictures', 'public')
        ]);

        return back();
    }
}
