<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class LikeTweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        $tweet->likes()->create(['user_id' => auth()->id()]);

         return back();
    }
}
