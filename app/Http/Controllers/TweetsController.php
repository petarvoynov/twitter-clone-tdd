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

        $tweets = $activities->map(function($activity) {  
            return $activity->subject;
        });
        /* 
        
        
        
        Huge comment

        we need to make our subject the comment, retweet and like models and save the activities throught their relationship
        
        
        
        
        */

        dd($tweets);

        $tweets = Tweet::with(['user', 'comments'])->whereIn('user_id', $followings)->orderByDesc('created_at')->get();

        $retweets = Retweet::with(['tweet', 'user'])->whereIn('user_id', $followings)->get();

        $retweets = $retweets->map(function($retweet){
            $tweet = $retweet->tweet;
            $tweet['is_retweet'] = 1;
            $tweet['retweet_user_name'] = $retweet->user->name;
            $tweet['retweeted_at'] = $retweet->created_at;

            return $tweet;
        });
        
        $tweets = $tweets->merge($retweets)->sortByDesc('created_at')->paginate(10);

        return view('tweets.index', compact('tweets'));
    }

    public function store()
    {
        $data = $this->validatedData();

        $tweet = auth()->user()->tweets()->create($data);

        $tweet->activities()->create([
            'user_id' => auth()->id(),
            'description' => 'created'
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
