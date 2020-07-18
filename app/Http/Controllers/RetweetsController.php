<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Retweet;

class RetweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        $tweet->retweet();

        $tweet->activities()->create([
            'user_id' => auth()->id(),
            'description' => 'retweet'
        ]);
       

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        
        $tweet->activities()->where('user_id', auth()->id())->where('description', 'retweet')->delete();

        $tweet->retweets()->where('user_id', auth()->id())->delete();

        return back();
    }
}
