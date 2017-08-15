<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
    	$this->expectException('Illuminate\Auth\AuthenticationException');

		$user   = create('App\User');
		$thread = create('App\Thread');
		$reply  = make('App\Reply');

        // when a user adds a reply to the thread
        $this->post($thread->path() . '/replies', $reply->toArray());
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
		$thread = create('App\Thread');
		$reply  = make('App\Reply');

        // Sign in
        $this->signIn();

        // when a user adds a reply to the thread
        $this->post($thread->path() . '/replies', $reply->toArray());

        // then their reply should be visible in page
        $this->get($thread->path())
        	->assertSee($reply->body);
    }
}
