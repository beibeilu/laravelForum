<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $response = $this->get($this->thread->showThreadPath())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_that_are_associated_with_the_thread()
    {
        $reply = create('App\Reply', ['thread_id'=>$this->thread->id]);

        $response = $this->get($this->thread->showThreadPath())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_channel(){
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
