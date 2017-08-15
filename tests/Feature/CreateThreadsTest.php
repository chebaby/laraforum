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
       	$this->signIn();

       	// When we hit the endpoint to create thread
       	$thread = make('App\Thread');

       	$this->post('/threads', $thread->toArray());

       	// Then we visit the thread page
       	$response = $this->get($thread->path());

       	// We should se the new thread
       	$response->assertSee($thread->title)
       		->assertSee($thread->body);
    }

    /** @test */
    public function guests_can_not_create_a_thread()
    {
    	$this->expectException('Illuminate\Auth\AuthenticationException');

    	// When we hit the endpoint to create thread
       	$thread = make('App\Thread');

       	$this->post('/threads', $thread->toArray());
    }


    /** @test */
    public function guests_can_not_see_the_create_thread_page()
    {
    	$this->withExceptionHandling()
    		->get('/threads/create')
    		->assertRedirect('/login');
    }
}
