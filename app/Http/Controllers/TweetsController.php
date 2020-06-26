<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use DB;

class TweetsController extends Controller
{
    public function index()
    {   
        $followings = auth()->user()->load('followings')->followings->pluck('id');
        $followings[] = auth()->id();

        $tweets = Tweet::with(['user', 'comments'])->whereIn('user_id', $followings)->orderByDesc('created_at')->paginate(10);

        return view('tweets.index', compact('tweets'));
    }

    public function store()
    {
        $data = $this->validatedData();

        auth()->user()->tweets()->create($data);
        
        return redirect()->route('tweets.index');
    }

    public function update(Tweet $tweet)
    {
        $data = $this->validatedData();

        if(auth()->id() != $tweet->user_id){
            abort(403);
        }

        $tweet->update($data);

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

    protected function validatedData()
    {
        return request()->validate([
            'body' => 'required'
        ]);
    }
}
