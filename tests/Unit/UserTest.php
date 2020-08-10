<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
   
    /** @test */
    function a_user_has_tweets()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->tweets);
    }

    /** @test */
    function a_user_has_followers()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->followers);
    }

    /** @test */
    function a_user_has_followings()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->followings);
    }

    /** @test */
    function a_user_can_call_a_method_follow()
    {
        // Given we are sign in and have a user to follow
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        // When we call the method follow
        $user->follow($userToFollow);
        
        // Then we should have one followed user
        $this->assertCount(1, $user->followings);

        // Then we should assert that we followed exactly this user
        $this->assertTrue($user->followings->contains($userToFollow));
    }

    /** @test */
    function a_user_has_comments()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->comments);
    }

    /** @test */
    function a_user_has_retweets()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->retweets);
    }

    /** @test */
    function a_user_has_activities()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->activities);
    }

    /** @test */
    function a_user_has_subscriptions()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->subscriptions);
    }

    /** @test */
    function a_user_has_many_subscribers()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->subscribers);
    }

    /** @test */
    function a_user_has_many_lists()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->lists);
    }
}
