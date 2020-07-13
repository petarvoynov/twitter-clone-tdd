<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function activities()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
