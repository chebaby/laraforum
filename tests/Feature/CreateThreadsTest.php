<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function guests_may_not_create_threads()
    {
    	$this->withExceptionHandling();

    	// Guest can not see the create thread page
    	$this->get('/threads/create')
    		->assertRedirect('/login');

    	// Guest can not create threads
    	$this->post('/threads')
    		->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_can_create_a_thread()
    {
    	// Given we have a signed in user
       	$this->signIn();

       	// When we hit the endpoint to create thread
       	$thread = create('App\Thread');

       	$this->post('/threads', $thread->toArray());

       	// Then we visit the thread page
       	$response = $this->get($thread->path());

       	// We should se the new thread
       	$response->assertSee($thread->title)
       		->assertSee($thread->body);
    }

}
