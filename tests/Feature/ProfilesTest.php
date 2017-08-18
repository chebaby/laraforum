<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
	use DatabaseMigrations;
    

    /** @test */
    function a_user_has_a_profile()
    {
    	$user = create('App\User');

        $this->get('/profile/' . $user->name)
        	->assertSee($user->name);
    }


    /** @test */
    function a_profiles_should_display_threads_created_by_the_associated_user()
    {
    	$this->signIn();

    	$thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/profile/' . auth()->user()->name)
        	->assertSee($thread->title)
        	->assertSee($thread->body);
    }


    /** @test */
    function it_fetch_activity_feed_for_any_user()
    {
        $this->signIn();

        // Given we have 2 thread
        create('App\Thread', ['user_id' => auth()->id()], 2);

        // One thread is from a week ago
        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        // When we fetch their feed
        $feed = Activity::feed(auth()->user());

        // Then it should be retruned in the right format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
