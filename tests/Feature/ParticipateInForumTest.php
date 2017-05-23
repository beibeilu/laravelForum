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
    public function unauthorized_user_can_not_delete_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_may_delete_a_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', $reply->toArray());

    }

    /** @test */
    public function authorized_user_may_update_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedBody = 'You been changed.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedBody]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedBody]);
    }

    /** @test */
    public function unauthorized_user_can_not_update_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $updatedBody = 'You been changed.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedBody])
            ->assertRedirect('login');
        $this->signIn()->patch("/replies/{$reply->id}", ['body' => $updatedBody])
            ->assertStatus(403);
    }
}
