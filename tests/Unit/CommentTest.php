<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Tweet;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_comment_belongs_to_a_tweet()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(Tweet::class, $comment->tweet);
    }
}
