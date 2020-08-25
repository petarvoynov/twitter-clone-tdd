<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use App\Tweet;

class BookmarksController extends Controller
{
    public function index()
    {
        $bookmarks = auth()->user()->bookmarks->sortByDesc('created_at')->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Tweet $tweet)
    {
        if($tweet->isBookmarked()){
            abort(403);
        }

        $tweet->bookmark();
        
        return back();
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->unbookmark();

        return back();
    }

    public function search()
    {
        $bookmarksIds = auth()->user()->bookmarks->pluck('tweet_id');
        $inputValue = request('body');
        $tweets = Tweet::whereIn('id', $bookmarksIds)->where('body', 'like', '%'. $inputValue .'%')->get();
        
        return view('bookmarks.search', compact('tweets', 'inputValue'));
    }
}
