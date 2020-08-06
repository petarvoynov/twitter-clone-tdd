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
            'description' => 'commented a tweet'
        ]);

        return back();

    }

    public function update(Tweet $tweet, Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = request()->validate([
            'body' => 'required'
        ]);
        
        $comment->update(request(['body']));

        return back();
    }

    public function destroy(Tweet $tweet, Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->activities()->where('user_id', auth()->id())->where('description', 'commented a tweet')->delete();

        $comment->delete();
    }
}
