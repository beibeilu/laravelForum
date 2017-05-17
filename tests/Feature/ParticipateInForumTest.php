<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_may_not_add_replies(){

        // Given no auth user

        $this->expectException('Illuminate\Auth\AuthenticationException');      // Then this test should throw AuthenticationException

        // when a reply is created in a thread
        $this->post('/threads/1/replies', []);  // empty reply body.

    }

    /** @test */
    public function an_authenticated_user_may_participates_in_forum_threads()
    {
        // Given a authenticated user
        $this->be($user = factory('App\User')->create());   // be() sets the current authenticate user.

        // and an existing thread
        $thread = factory('App\Thread')->create();

        // when the user adds a reply to the thread
        $reply = factory('App\Reply')->make();      // make a reply, create = make + submit to database.

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());     // save the reply to the database

        // then they reply should be visible on the page
        $this->get('/threads/' . $thread->id)
            ->assertSee($reply->body);
    }
}
