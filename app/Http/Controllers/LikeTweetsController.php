<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class LikeTweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        if(!$tweet->isLiked()){
            $tweet->like();
        }
        
         return back();
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->unlike();

        return back();
    }
}
