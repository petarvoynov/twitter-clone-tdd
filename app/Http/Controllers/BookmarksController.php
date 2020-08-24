<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use App\Tweet;

class BookmarksController extends Controller
{
    public function store(Tweet $tweet)
    {
        Bookmark::create([
            'user_id' => auth()->id(),
            'tweet_id' => $tweet->id
        ]);
    }
}
