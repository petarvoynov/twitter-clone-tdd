<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    protected $with = ['likes'];
    protected $withCount = ['likes', 'comments', 'retweets'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function like()
    {
        return $this->likes()->create(['user_id' => auth()->id()]);
    }

    public function unlike()
    {
        $this->likes()->where('user_id', auth()->id())->delete();
    }

    public function isLiked()
    {
        return !! $this->likes->where('user_id', auth()->id())->count();
    }

    public function retweets()
    {
        return $this->hasMany('App\Retweet');
    }

    public function retweet()
    {
        return $this->retweets()->create(['user_id' => auth()->id()]);
    }

    public function activities()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
    
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
