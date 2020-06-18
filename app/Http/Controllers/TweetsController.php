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

        auth()->user()->tweets()->create($data);
        
        return redirect()->route('tweets.index');
    }

    public function update(Tweet $tweet)
    {
        if(auth()->id() != $tweet->user_id){
            abort(403);
        }

        $tweet->update(['body' => request('body')]);

        return redirect()->route('tweets.index');
    }

    public function destroy(Tweet $tweet)
    {
        if(auth()->id() != $tweet->user_id){
            abort(403);
        }

        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}
