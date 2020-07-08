<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tweet()
    {
        return $this->belongsTo('App\Tweet');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
