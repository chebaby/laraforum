<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
        	'type' => 'created_thread',
        	'user_id' => auth()->id(),
        	'subject_id' => $thread->id,
        	'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertequals($activity->subject->id, $thread->id);
    }


    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
    	$this->signIn();

    	$reply = create('App\Reply');

    	$this->assertequals(2, Activity::count());
    }
}
