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
            
            $like = $tweet->like();
            
            $like->activities()->create([
                'user_id' => auth()->id(),
                'description' => 'tweet'
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
