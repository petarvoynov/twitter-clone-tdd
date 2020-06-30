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

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->retweets()->where('user_id', auth()->id())->delete();

        return back();
    }
}
