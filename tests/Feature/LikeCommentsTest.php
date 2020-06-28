<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_like_comments()
    {
        $this->post('/comments/1/like')
            ->assertRedirect('login');
    }

    /** @test */
    function a_comment_can_be_liked()
    {
        // Given we are sing in and we have a comment
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        // When we hit the route to like that comment
        $this->post('/comments/'. $comment->id .'/like');

        // Then this should be shown in the database
        $this->assertCount(1, $comment->likes);
    }

    /** @test */
    function a_comment_cannot_be_liked_more_than_once()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and we have a comment
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        // When we hit the route to like that comment more than once
        $this->post('/comments/'. $comment->id .'/like');
        $this->post('/comments/'. $comment->id .'/like');
        $this->post('/comments/'. $comment->id .'/like');

        // Then there should still be only one record in the database
        $this->assertCount(1, $comment->likes);
    }

    /** @test */
    function a_comment_can_be_unliked()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and have a comment that we liked
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);
        $comment->like();

        // When we hit the route to unlike that comment 
        $this->delete('/comments/' . $comment->id . '/unlike');

        // Then there should not be any records in the database
        $this->assertCount(0, $comment->likes);
    }
}
