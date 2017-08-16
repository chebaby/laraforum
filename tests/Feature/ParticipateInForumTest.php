<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_add_replies()
    {
    	$this->withExceptionHandling()
    		->post('/threads/channel-slug/thread-slug/replies', [])
    		->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

		$thread = create('App\Thread');
		$reply  = make('App\Reply');

        // when a user adds a reply to the thread
        $this->post($thread->path() . '/replies', $reply->toArray());

        // then their reply should be visible in page
        $this->get($thread->path())
        	->assertSee($reply->body);
    }


    /** @test */
    public function a_reply_require_a_body()
    {
    	$this->publishReply(['body' => null])
    		->assertSessionHasErrors('body');
    }


    protected function publishReply($overrides = [])
    {
    	$this->withExceptionHandling()->signIn();

		$thread = create('App\Thread');
		$reply  = make('App\Reply', $overrides);

        // when a user adds a reply to the thread
        return $this->post($thread->path() . '/replies', $reply->toArray());
    }
}
