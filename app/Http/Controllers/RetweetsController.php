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
            'description' => 'this tweet is being retweeted'
        ]);

        return back()->with('success', 'You successfully retweeted the tweet.');
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->activities()->where('user_id', auth()->id())->where('description', 'this tweet is being retweeted')->delete();

        /* WE PROBABLY DOESN'T NEED A RETWEET MODEL AND MIGRATION JUST CONTROLLER */

        $tweet->retweets()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'You successfully unretweeted the tweet.');
    }
}
