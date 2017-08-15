<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_a_thread()
    {
    	// Given we have a signed in user
       	$user = factory('App\User')->create();

       	$this->actingAs($user);

       	// When we hit the endpoint to create thread
       	$thread = factory('App\Thread')->make();

       	$this->post('/threads', $thread->toArray());

       	// Then we visit the thread page
       	$response = $this->get($thread->path());

       	// We should se the new thread
       	$response->assertSee($thread->title)
       		->assertSee($thread->body);
    }

    /** @test */
    public function unanthenticated_can_not_create_a_thread()
    {
    	$this->expectException('Illuminate\Auth\AuthenticationException');

    	// When we hit the endpoint to create thread
       	$thread = factory('App\Thread')->make();

       	$this->post('/threads', $thread->toArray());
    }
}
