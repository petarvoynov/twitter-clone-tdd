<?php

namespace App\Observers;

use App\Like;
use App\Activity;

class LikeObserver
{
    /**
     * Handle the like "created" event.
     *
     * @param  \App\Like  $like
     * @return void
     */
    public function created(Like $like)
    {
        if($like->likeable_type == 'App\Tweet'){
            Activity::create([
                'user_id' => $like->user_id,
                'subject_id' => $like->likeable_id,
                'subject_type' => $like->likeable_type,
                'description' => 'this tweet is being liked'
            ]);
        } else if($like->likeable_type == 'App\Comment'){
            Activity::create([
                'user_id' => $like->user_id,
                'subject_id' => $like->likeable_id,
                'subject_type' => $like->likeable_type,
                'description' => 'this comment is being liked'
            ]);
        }
    }

    /**
     * Handle the like "updated" event.
     *
     * @param  \App\Like  $like
     * @return void
     */
    public function updated(Like $like)
    {
        //
    }

    /**
     * Handle the like "deleted" event.
     *
     * @param  \App\Like  $like
     * @return void
     */
    public function deleted(Like $like)
    {
        //
    }

    /**
     * Handle the like "restored" event.
     *
     * @param  \App\Like  $like
     * @return void
     */
    public function restored(Like $like)
    {
        //
    }

    /**
     * Handle the like "force deleted" event.
     *
     * @param  \App\Like  $like
     * @return void
     */
    public function forceDeleted(Like $like)
    {
        //
    }
}
