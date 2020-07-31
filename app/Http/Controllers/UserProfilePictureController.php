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
    }
}
