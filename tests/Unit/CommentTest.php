<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Tweet;
use App\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_comment_can_be_morped_to_a_tweet()
    {
        $comment = factory('App\Comment')->create([
            'commentable_id' => factory('App\Tweet'),
            'commentable_type' => 'App\Tweet'
        ]);
        $this->assertInstanceOf(Tweet::class, $comment->commentable);
    }

    /** @test */
    function a_comment_belongs_to_a_user()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /** @test */
    function a_comment_has_many_likes()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(Collection::class, $comment->likes);
    }

    /** @test */
    function a_comment_can_call_like_method()
    {
        // Given we are sign in and have a comment
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create();

        // When we call the method to like a comment 
        $comment->like();

        // Then there should be a result in the database
        $this->assertCount(1, $comment->likes);
    }

    /** @test */
    function a_comment_can_call_unlike_method()
    {
        // Given we are sign in and have a comment that we liked
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        $comment->like();

        // When we call the method to unlike the comment
        $comment->unlike();

        // Then there should not be record in the database
        $this->assertCount(0, $comment->likes);
    }
}
