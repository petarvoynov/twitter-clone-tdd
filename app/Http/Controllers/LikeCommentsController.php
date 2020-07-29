<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Like;

class LikeCommentsController extends Controller
{
    public function store(Comment $comment)
    {
        if(!$comment->isLiked()){
            $comment->like();

            $comment->activities()->create([
                'user_id' => auth()->id(),
                'description' => 'this comment is being liked'
            ]);
        } 
       
        return back();
    }

    public function destroy(Comment $comment)
    {
        if($comment->isLiked()){
            $comment->activities()->where('user_id', auth()->id())->where('description', 'this comment is being liked')->delete();

            $comment->unlike();
        }

        return back();
    }
}