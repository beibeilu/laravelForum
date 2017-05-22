<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_reply_is_created()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        // Given a thread and a thread a week earlier
        create('App\Thread', ['user_id' => Auth()->id()], 2);

        auth()->user()->activities->first()->update([
            'created_at' => Carbon::now()->subWeek(),
        ]);

        // When fetch their feed
        $response = Activity::feed(auth()->user(), 50);

        // Return with proper format
        $this->assertTrue($response->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($response->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
