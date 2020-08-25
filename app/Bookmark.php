<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $guarded = [];

    protected $with = ['tweet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
