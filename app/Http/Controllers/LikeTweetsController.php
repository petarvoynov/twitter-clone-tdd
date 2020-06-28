<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class LikeTweetsController extends Controller
{
    public function store(Tweet $tweet)
    {
        $tweet->like();

         return back();
    }
}
