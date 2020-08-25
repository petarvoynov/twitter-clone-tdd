<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Tweet;

class BookmarksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_bookmark_a_tweet()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and follow a users that has a tweet
        $user = $this->signIn();

        $userToFollow = factory(User::class)->create();

        $tweet = factory(Tweet::class)->create(['user_id' => $userToFollow->id]);
        
        $user->follow($userToFollow);

        // When we hit the route to bookmark this tweet
        $this->post("/tweets/{$tweet->id}/bookmark");

        // Then there should be a record in the database
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }

    /** @test */
    function a_user_cannot_bookmark_the_same_tweet_more_than_once()
    {
        // Given we are sing in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to bookmark the tweet more than once
        $this->post("/tweets/{$tweet->id}/bookmark");
        $this->post("/tweets/{$tweet->id}/bookmark");
        $this->post("/tweets/{$tweet->id}/bookmark");

        // Then there should be one record in the database for bookmarking this tweet
        $this->assertEquals(1, $tweet->bookmarks->count());
    }

    /** @test */
    function a_user_can_unbookmark_tweets()
    {
        // Given we are sing in and have a tweet and bookmark for this tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        $tweet->bookmark();

        // When we hit the route to unbookmark this tweet
        $this->delete("/tweets/{$tweet->id}/unbookmark");

        // Then we there shouldn't be records in the database
        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }

    /** @test */
    function bookmarks_can_be_searched()
    {
        $user = $this->signIn();

        $tweetToSee = factory('App\Tweet')->create(['body' => 'We should see it']);
        $tweetToSee2 = factory('App\Tweet')->create(['body' => 'This should be seen']);
        $tweetNotToSee = factory('App\Tweet')->create(['body' => 'This not']);
        $tweetNotToSee2 = factory('App\Tweet')->create(['body' => 'This not as well']);

        $tweetToSee->bookmark();
        $tweetToSee2->bookmark();
        $tweetNotToSee->bookmark();
        $tweetNotToSee2->bookmark();

        // When we hit the form to search a tweet
        $response = $this->post('/bookmarks/search', ['body' => 'should']);

        // Then there should be correct tweet record on the page
        $response->assertSee($tweetToSee->body, $tweetToSee2);
        $response->assertDontSee($tweetNotToSee->body, $tweetNotToSee2);

    }
}
