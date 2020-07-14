<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Comment;
use App\Activity;

class CommentsController extends Controller
{
    public function store(Tweet $tweet)
    {
        request()->validate([
            'body' => 'required'
        ]);
        
        $comment = auth()->user()->comments()->create([
            'body' => request('body'),
            'tweet_id' => $tweet->id,
        ]);

        $comment->activities()->create([
            'user_id' => auth()->id(),
            'description' => 'comment'
        ]);

        return back();

    }
}
