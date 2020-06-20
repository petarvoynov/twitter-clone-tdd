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
}
