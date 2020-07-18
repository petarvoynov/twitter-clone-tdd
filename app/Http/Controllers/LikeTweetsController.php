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
            
            $tweet->activities()->create([
                'user_id' => auth()->id(),
                'description' => 'like'
            ]);
        }

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        if($tweet->isLiked()) {
            $tweet->activities()->where('user_id', auth()->id())->where('description', 'like')->delete();

            $tweet->unlike();
        } 
        
        return back();
    }
}
