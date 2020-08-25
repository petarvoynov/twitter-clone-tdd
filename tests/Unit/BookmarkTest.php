<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Bookmark;
use App\User;
use App\Tweet;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_bookmark_belongs_to_a_user()
    {
        $bookmark = factory(Bookmark::class)->create();

        $this->assertInstanceOf(User::class, $bookmark->user);
    }

    /** @test */
    function a_bookmark_belongs_to_a_tweet()
    {
        $bookmark = factory(Bookmark::class)->create();

        $this->assertInstanceOf(Tweet::class, $bookmark->tweet);
    }
}
