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
            Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $comment->id,
                'likeable_type' => get_class($comment)
            ]);
        }
    }
}