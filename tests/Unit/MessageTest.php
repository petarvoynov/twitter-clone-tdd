<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\User;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_message_belongs_to_a_sender()
    {
        $message = factory('App\Message')->create();

        $this->assertInstanceOf(User::class, $message->sender);
    }
}
