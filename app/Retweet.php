<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    protected $guarded = [];

    public function tweet()
    {
        return $this->belongsTo('App\Tweet');
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
