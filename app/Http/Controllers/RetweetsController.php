<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Retweet;

class RetweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        $retweet = $tweet->retweet();

        $retweet->activities()->create([
            'user_id' => auth()->id(),
            'description' => 'tweet'
        ]);

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        
        $retweet = $tweet->retweets()->where('user_id', auth()->id())->first();

        $retweet->activities()->delete();

        $tweet->retweets()->where('user_id', auth()->id())->delete();

        return back();
    }
}
