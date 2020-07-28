<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class LikeTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   function a_like_has_morph_many_activities()
   {
        $like = factory('App\Like')->create();

        $this->assertInstanceOf(Collection::class, $like->activities);
   }

   /** @test */
   function a_like_belongs_to_a_user()
   {
       $like = factory('App\Like')->create();

       $this->assertInstanceOf('App\User', $like->user);
   }
}
