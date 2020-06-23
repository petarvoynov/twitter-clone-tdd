<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Tweet $tweet)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $comment = Comment::create([
            'tweet_id' => $tweet->id,
            'body' => request('body')
        ]);
    }
}
