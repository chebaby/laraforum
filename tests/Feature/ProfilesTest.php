<?php

namespace Tests\Feature;

use Tests\TestCase;
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
    	$user = create('App\User');

    	$thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get('/profile/' . $user->name)
        	->assertSee($thread->title)
        	->assertSee($thread->body);
    }
}
