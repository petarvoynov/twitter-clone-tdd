<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TweetCreated;
use App\Tweet;
use App\Retweet;
use App\Comment;
use App\Activity;
use DB;

class TweetsController extends Controller
{
    public function index()
    {   
        $followings = auth()->user()->load('followings')->followings->pluck('id');
        // Commented the code below so we wont see our activities in the /tweets page
        /* $followings[] = auth()->id(); */
        
        $activities = Activity::whereIn('user_id', $followings)->with('subject')->get()->loadMorph('subject', [
            Tweet::class => ['user', 'bookmarks'],
            Comment::class => ['tweet.user'],
            Retweet::class => ['tweet.bookmarks']
        ])->paginate(15);

        return view('tweets.index', compact('activities'));
    }

    public function store()
    {
        $data = $this->validatedData();

        $tweet = auth()->user()->tweets()->create($data);

        auth()->user()->notifySubscribers($tweet);
        
        return redirect()->route('tweets.index')->with('success', 'You successfully posted a tweet.');
    }

    public function show(Tweet $tweet)
    {
        $this->authorize('view', $tweet);

        if(strpos(url()->previous(), url('/notifications')) !== false || strpos(url()->previous(), url('/unread-notifications')) !== false){
            auth()->user()->notifications()->where('data','LIKE','%"tweet_id":'. $tweet->id .'%')->first()->markAsRead();
        }

        $comments = $tweet->comments->paginate(10);

        return view('tweets.show', compact('tweet', 'comments'));
    }

    public function update(Tweet $tweet)
    {
        $this->authorize('update', $tweet);

        $data = $this->validatedData();

        $tweet->update($data);

        return redirect()->route('tweets.index')->with('success', 'You successfully updated the tweet.');
    }

    public function destroy(Tweet $tweet)
    {
        $this->authorize('delete', $tweet);
        
        $tweet->delete();

        return redirect()->route('tweets.index')->with('success', 'You successfully deleted the tweet.');
    }

    protected function validatedData()
    {
        return request()->validate([
            'body' => 'required'
        ]);
    }
}
