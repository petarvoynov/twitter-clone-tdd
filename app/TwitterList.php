<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterList extends Model
{
    protected $guarded = [];

    public function coverImage()
    {
        if($this->cover_image != 'default.jpg'){
            return "/storage/{$this->cover_image}";
        }

        return '/default-image/default.jpg';
    }

    public function pin()
    {
        $this->update([
            'is_pinned' => 1
        ]);

        return $this;
    }

    public function listUsers()
    {
        return $this->hasMany('App\ListUser', 'list_id');
    }

    public function holds($user_id)
    {
        return !! $this->listUsers->where('user_id', $user_id)->count();
    }
}
