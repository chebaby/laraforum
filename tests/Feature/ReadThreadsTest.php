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


    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        // Given we have three threads
        // with 3 replies, 2 replies, 0 replies respectively.
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithNoReplies = $this->thread;

        // When i filter all thread by populariy.
        $response = $this->getJson('threads?popular=1')->json();
        
        // Then they should be returned from most replies to least.
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
