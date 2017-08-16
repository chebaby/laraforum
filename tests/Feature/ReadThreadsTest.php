<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;


	public function setUp()
	{
		parent::setUp();

		$this->thread = create('App\Thread');
	}

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
        	->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
    	$this->get($this->thread->path())
    		->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_that_are_related_with_a_thread()
    {
    	$reply = create('App\Reply', [ 'thread_id' => $this->thread->id ]);

    	$this->get($this->thread->path())
    		->assertSee($reply->body);
    }


    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }


    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create('App\User', ['name' => 'johnDoe']));
        
        $threadByJohnDoe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohnDoe = create('App\Thread');

        $this->get('/threads?by=johnDoe')
            ->assertSee($threadByJohnDoe->title)
            ->assertDontSee($threadNotByJohnDoe->title);
    }
}
