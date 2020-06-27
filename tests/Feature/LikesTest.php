<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_like_comments()
    {
        $this->post('/comments/1/likes')
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
        $this->post('/comments/'. $comment->id .'/likes');

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
        $this->post('/comments/'. $comment->id .'/likes');
        $this->post('/comments/'. $comment->id .'/likes');
        $this->post('/comments/'. $comment->id .'/likes');

        // Then there should still be only one record in the database
        $this->assertCount(1, $comment->likes);
    }
}
