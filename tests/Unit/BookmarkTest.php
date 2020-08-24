<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Bookmark;
use App\User;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_bookmark_belongs_to_a_user()
    {
        $bookmark = factory(Bookmark::class)->create();

        $this->assertInstanceOf(User::class, $bookmark->user);
    }
}
