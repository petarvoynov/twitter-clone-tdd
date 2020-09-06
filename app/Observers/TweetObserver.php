<?php

namespace App\Observers;

use App\Tweet;
use App\Activity;

class TweetObserver
{
    /**
     * Handle the tweet "created" event.
     *
     * @param  \App\Tweet  $tweet
     * @return void
     */
    public function created(Tweet $tweet)
    {
        Activity::create([
            'user_id' => $tweet->user_id,
            'subject_id' => $tweet->id,
            'subject_type' => 'App\Tweet',
            'description' => 'created a tweet'
        ]);
    }

    /**
     * Handle the tweet "updated" event.
     *
     * @param  \App\Tweet  $tweet
     * @return void
     */
    public function updated(Tweet $tweet)
    {
        //
    }

    /**
     * Handle the tweet "deleted" event.
     *
     * @param  \App\Tweet  $tweet
     * @return void
     */
    public function deleted(Tweet $tweet)
    {
        //
    }

    /**
     * Handle the tweet "restored" event.
     *
     * @param  \App\Tweet  $tweet
     * @return void
     */
    public function restored(Tweet $tweet)
    {
        //
    }

    /**
     * Handle the tweet "force deleted" event.
     *
     * @param  \App\Tweet  $tweet
     * @return void
     */
    public function forceDeleted(Tweet $tweet)
    {
        //
    }
}
