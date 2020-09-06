<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    protected $with = ['user', 'likes'];

    protected $withCount = ['likes'];

    public function tweet()
    {
        return $this->belongsTo('App\Tweet');
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
        $this->likes()->where('user_id', auth()->id())->get()->each->delete();
    }

    public function isLiked()
    {
        return !! $this->likes->where('user_id', auth()->id())->count();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function activities()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
