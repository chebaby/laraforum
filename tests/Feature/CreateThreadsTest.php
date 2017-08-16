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
       	$thread = make('App\Thread');

       	$response = $this->post('/threads', $thread->toArray());

       	// Then we visit the thread page
       	$this->get($response->headers->get('location'))
       		// We should see the new thread
       		->assertSee($thread->title)
       		->assertSee($thread->body);
    }


    /** @test */
    public function a_thread_require_a_title()
    {
    	$this->publishThread(['title' => null])
    		->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_thread_require_a_body()
    {
    	$this->publishThread(['body' => null])
    		->assertSessionHasErrors('body');
    }


    /** @test */
    public function a_thread_require_a_valid_channel()
    {
    	factory('App\Channel', 2)->create();

    	$this->publishThread(['channel_id' => null])
    		->assertSessionHasErrors('channel_id');

    	$this->publishThread(['channel_id' => 999])
    		->assertSessionHasErrors('channel_id');
    }


    protected function publishThread($overrides = [])
    {
    	$this->withExceptionHandling()->signIn();

    	$thread = make('App\Thread', $overrides);

    	return $this->post('/threads', $thread->toArray());

    	// Notes:
    	// if the validation for $overrides fields
    	// laravel will throw an Exception
    	// and redirect to previous page
    	// with errors in Session with $overrides as key
    }

}
