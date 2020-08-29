<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserProfilePictureController extends Controller
{
    public function store()
    {
        request()->validate([
            'profile_picture' => 'required|image'
        ]);

        // Remove the old image unless the image is noimage.jpg
        if(auth()->user()->profile_picture !== 'noimage.jpg' && !is_null(auth()->user()->profile_picture)){
            $file_path = storage_path().'/'. auth()->user()->profile_picture;
            $file_path = 'storage/' . auth()->user()->profile_picture;

            if(file_exists($file_path)) {
                unlink($file_path);
            }
        }

        auth()->user()->update([
            'profile_picture' => request()->file('profile_picture')->store('profile_pictures', 'public')
        ]);
        
        return back()->with('success', 'You successfully updated your profile picture.');
    }

    public function edit(User $user)
    {
        return view('users.profile_picture.edit', compact('user'));
    }
}
