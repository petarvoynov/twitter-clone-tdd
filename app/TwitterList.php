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
}
