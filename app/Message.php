<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    
    protected $with = ['sender'];

    public function sender()
    {
        return $this->belongsTo('App\User', 'from');
    }
}
