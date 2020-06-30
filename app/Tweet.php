<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    protected $with = ['likes'];
    protected $withCount = ['likes'];

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
}
