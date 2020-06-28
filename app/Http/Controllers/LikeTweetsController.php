<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class LikeTweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        if(!$tweet->likes()->where('user_id', auth()->id())->exists()){
            $tweet->like();
        }
        
         return back();
    }
}
