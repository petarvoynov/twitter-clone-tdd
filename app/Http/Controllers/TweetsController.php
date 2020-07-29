<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Retweet;
use App\Activity;
use DB;

class TweetsController extends Controller
{
    public function index()
    {   
        $followings = auth()->user()->load('followings')->followings->pluck('id');
        $followings[] = auth()->id();
        
        $activities = Activity::whereIn('user_id', $followings)->get();

        return view('tweets.index', compact('activities'));
    }

    public function store()
    {
        $data = $this->validatedData();

        $tweet = auth()->user()->tweets()->create($data);

        $tweet->activities()->create([
            'user_id' => auth()->id(),
            'description' => 'created a tweet'
        ]);
        
        return redirect()->route('tweets.index');
    }

    public function show(Tweet $tweet)
    {
        return view('tweets.show', compact('tweet'));
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

        /* NEED TO DELETE THE ACTIVITY FOR CREATING THE TWEET */

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
