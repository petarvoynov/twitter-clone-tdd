<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class TwitterListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_twitter_list_has_many_users()
    {
        $list = factory('App\TwitterList')->create();

        $this->assertInstanceOf(Collection::class, $list->listUsers);
    }

    /** @test */
    function a_twitter_list_can_call_isPinned_method()
    {
        $pinnedList = factory('App\TwitterList')->create(['is_pinned' => 1]);
        $unpinnedList = factory('App\TwitterList')->create(['is_pinned' => 0]);

        $this->assertTrue($pinnedList->isPinned());
        $this->assertFalse($unpinnedList->isPinned());
    }
}
