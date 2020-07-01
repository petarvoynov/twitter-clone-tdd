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
}
