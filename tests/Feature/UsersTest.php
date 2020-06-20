<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_follow_another_user()
    {
        // Given are sign in and we have a user to follow
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        // When he hit the route to follow another user
        $this->post('/users/'. $userToFollow->id .'/follow');

        // Then when we call the relationship we should have one record
        $this->assertCount(1, $user->followings);

        // Then when we call the relationship we have to have it in the results
        $this->assertEquals($userToFollow->id, $user->followings->first()->id);
    }

    /** @test */
    function a_user_can_unfollow_a_followed_user()
    {
        $this->withoutExceptionHandling();
        // Given are sign in and already followed a user
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();
        $this->post('/users/'. $userToFollow->id .'/follow');

        // When we hit the route to unfollow this user
        $this->post('/users/'. $userToFollow->id .'/unfollow');

        //Then when we call the relationship we should have no records
        $this->assertCount(0, $user->followings);
    }
    
   
    /** @test */
    function a_user_cannot_follow_a_user_if_he_is_already_following_him()
    {
        // Given we are sign in and have followed a user
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        $user->follow($userToFollow);

        // When we hit the route to follow him again

        $this->post('/users/' . $userToFollow->id . '/follow');

        // Then we should not have anoter record of following this user
        $this->assertCount(1, $user->followings);

    }
}
