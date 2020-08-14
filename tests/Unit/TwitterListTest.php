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
}
