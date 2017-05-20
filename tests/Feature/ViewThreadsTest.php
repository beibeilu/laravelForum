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

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create('App\User', ['name' => 'Beibei']));
        $threadByBeibei = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByBeibei = create('App\Thread');

        $this->get('threads?by=Beibei')
            ->assertSee($threadByBeibei->title)
            ->assertDontSee($threadNotByBeibei->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWith5Replies = create('App\Thread');
        create('App\Reply', ['thread_id'=>$threadWith5Replies->id], 5);

        $threadWith2Replies = create('App\Thread');
        create('App\Reply', ['thread_id'=>$threadWith2Replies->id], 2);

        $threadWith0Replies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([5, 2, 0], array_column($response, 'replies_count'));
    }
}
