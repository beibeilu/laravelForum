<?php

namespace Tests\Feature;

use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_cannot_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/'. $reply->id . '/favorites');
//        dd(\App\Favorite::all());
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authorized_user_can_unfavorite_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $reply->favorited();

        $this->delete('replies/'. $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorited_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try {
            $this->post('replies/'. $reply->id . '/favorites');
            $this->post('replies/'. $reply->id . '/favorites');
        } catch(\Exception $e){
            $this->fail("Should not insert the record again.");
        }
        $this->assertCount(1, $reply->favorites);
    }

}
