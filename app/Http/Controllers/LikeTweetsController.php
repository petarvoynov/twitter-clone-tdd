<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Activity;

class LikeTweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        if(!$tweet->isLiked()) {
            $tweet->like();
        }

        return back()->with('success', 'You successfully liked the tweet.');
    }

    public function destroy(Tweet $tweet)
    {
        if($tweet->isLiked()) {
            $tweet->unlike();
        } 
        
        return back()->with('success', 'You successfully unliked the tweet.');
    }
}
