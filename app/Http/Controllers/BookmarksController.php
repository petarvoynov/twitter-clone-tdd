<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use App\Tweet;

class BookmarksController extends Controller
{
    public function store(Tweet $tweet)
    {
        $tweet->bookmark();
    }
}
