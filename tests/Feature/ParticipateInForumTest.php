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
        // when a reply is created in a thread
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participates_in_forum_threads()
    {
        // Given a authenticated user
        $this->signIn();

        // and an existing thread
        $thread = create('App\Thread');

        // when the user adds a reply to the thread
        $reply = make('App\Reply');      // make a reply, create = make + submit to database.

        $this->post($thread->showThreadPath() . '/replies', $reply->toArray());     // save the reply to the database

        // then they reply should be visible on the page
        $this->get($thread->showThreadPath())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->showThreadPath() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');

    }
}
