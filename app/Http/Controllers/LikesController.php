<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Like;

class LikesController extends Controller
{
    public function store(Comment $comment)
    {
        if(!$comment->likes()->where('user_id', auth()->id())->exists()){
            $comment->like();
        }

        return back();
    }

    public function destroy(Comment $comment)
    {
        if($comment->likes()->where('user_id', auth()->id())->exists()){
            $comment->likes()->where(['user_id' => auth()->id()])->delete();
        }

        return back();
    }
}