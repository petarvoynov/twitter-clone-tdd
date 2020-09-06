<?php

namespace App\Observers;

use App\Retweet;
use App\Activity;

class RetweetObserver
{
    /**
     * Handle the retweet "created" event.
     *
     * @param  \App\Retweet  $retweet
     * @return void
     */
    public function created(Retweet $retweet)
    {
        Activity::create([
            'user_id' => $retweet->user_id,
            'subject_id' => $retweet->tweet_id,
            'subject_type' => 'App\Tweet',
            'description' => 'this tweet is being retweeted'
        ]);
    }

    /**
     * Handle the retweet "updated" event.
     *
     * @param  \App\Retweet  $retweet
     * @return void
     */
    public function updated(Retweet $retweet)
    {
        //
    }

    /**
     * Handle the retweet "deleted" event.
     *
     * @param  \App\Retweet  $retweet
     * @return void
     */
    public function deleted(Retweet $retweet)
    {
        $retweet->tweet->activities()->where('user_id', auth()->id())->where('description', 'this tweet is being retweeted')->delete();
    }

    /**
     * Handle the retweet "restored" event.
     *
     * @param  \App\Retweet  $retweet
     * @return void
     */
    public function restored(Retweet $retweet)
    {
        //
    }

    /**
     * Handle the retweet "force deleted" event.
     *
     * @param  \App\Retweet  $retweet
     * @return void
     */
    public function forceDeleted(Retweet $retweet)
    {
        //
    }
}
