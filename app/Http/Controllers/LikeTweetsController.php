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
            
            Activity::create([
                'user_id' => auth()->id(),
                'subject_id' => $like->id,
                'subject_type' => get_class($like),
                'description' => 'like'
            ]);
        }

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        if($tweet->isLiked())  $tweet->unlike();
        
        return back();
    }
}
