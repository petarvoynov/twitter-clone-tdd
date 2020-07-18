<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Like;
use App\Comment;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_activity_can_be_morphed_to_like()
    {
        $activity = factory('App\Activity')->create([
            'subject_id' => factory('App\Like'),
            'subject_type' => 'App\Like'
        ]);

        $this->assertInstanceOf(Like::class, $activity->subject);
    }

    /** @test */
    function an_activity_can_be_morphed_to_comment()
    {
        $activity = factory('App\Activity')->create([
            'subject_id' => factory('App\Comment'),
            'subject_type' => 'App\Comment'
        ]);

        $this->assertInstanceOf(Comment::class, $activity->subject); 
    }
}
