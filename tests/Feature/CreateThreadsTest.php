<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_thread()
    {
        // guest may not create thread.
        $this->withExceptionHandling()
            ->post('/threads')
            ->assertRedirect('/login');

        // guest may not see thread create page.
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');    //raw gives array, make gives instance of thread

        $response = $this->post('/threads', $thread->toArray());    //use $response to find where the POSTed thread redirected.

        // then when visit the threads index, we should see the new thread.
        $this->get($response->headers->get('Location'))     // get the location where the response is heading, without creating the thread.
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_channel_id()
    {
        factory('App\Channel', 2)->create();

        // check channel id is provided.
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        // check channel id is valid - existed channel.
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');

    }

    public function publishThread($override = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $override);

        return $this->post('/threads', $thread->toArray());

    }

}