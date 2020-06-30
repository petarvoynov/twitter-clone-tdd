<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Retweet;

class RetweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        Retweet::create([
            'user_id' => auth()->id(),
            'tweet_id' => $tweet->id
        ]);

        return back();
    }
}
