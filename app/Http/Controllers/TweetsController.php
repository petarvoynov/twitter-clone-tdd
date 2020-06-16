<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class TweetsController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();

        return view('tweets.index', compact('tweets'));
    }
}
