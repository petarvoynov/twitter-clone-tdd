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

    public function store()
    {
        $data = request()->validate([
            'body' => 'required'
        ]);

        Tweet::create([
            'user_id' => auth()->user()->id,
            'body' => request('body')
        ]);
        
        return redirect()->route('tweets.index');
    }
}
