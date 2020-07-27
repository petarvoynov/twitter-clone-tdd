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
            $like = $comment->like();

            $like->activities()->create([
                'user_id' => auth()->id(),
                'description' => 'comment'
            ]);
        } 
       
        return back();
    }

    public function destroy(Comment $comment)
    {
        if($comment->isLiked()){
            $comment->activities()->where('user_id', auth()->id())->where('description', 'like')->delete();

            $comment->unlike();
        }

        return back();
    }
}