<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Tweet;
use App\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_comment_belongs_to_a_tweet()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(Tweet::class, $comment->tweet);
    }

    /** @test */
    function a_comment_belongs_to_a_user()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }
}
