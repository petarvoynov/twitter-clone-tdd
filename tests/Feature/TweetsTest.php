<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_can_see_all_tweets()
    {   
        // Given we are sign in
        $user = factory('App\User')->create();
        $this->actingAs($user);

        // Given there is a tweet
        $tweet = factory('App\Tweet')->create();

        // When a user goes to his homepage
        $response = $this->get('/homepage');
            
        // Then he should be able to see the tweets
        $response->assertSee($tweet->body);
        
    }
}
