<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use App\Tweet;

class BookmarksController extends Controller
{
    public function store(Tweet $tweet)
    {
        if($tweet->isBookmarked()){
            abort(403);
        }

        $tweet->bookmark();
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->unbookmark();
    }
}
