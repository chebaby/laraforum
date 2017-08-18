<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

	protected $guarded = [];


	protected $with = ['creator', 'channel'];


	protected static function boot()
	{
		parent::boot();

		// Advantage of global scopes over $with is you can disable
		// the global scope with withoutGlobalScopes() method
		// static::addGlobalScope('creator', function($builder) {
		// 	$builder->with('creator');
		// });
		
		static::addGlobalScope('replyCount', function($builder) {
			$builder->withCount('replies');
		});

		// When you deleting the thread, as part of this process
		// delete also any of it's related replies
		static::deleting(function($thread) {
			$thread->replies()->delete();
		});
	}


    public function replies()
	{
		return $this->hasMany(Reply::class);
					// When we fetch replies for a thread 
					// a part of that process, we want to include
					// the count of the favorites relationship
					//->withCount('favorites')
					//->with('owner');
					// BS: replaced with global scope in Reply.php
	}


	public function creator()
	{
		return $this->belongsTo('App\User', 'user_id');
	}


	public function channel()
	{
		return $this->belongsTo('App\Channel');
	}


	public function addReply($reply)
	{
		return $this->replies()->create($reply);
	}


    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }


    public function scopeFilter($query, $filters)
    {
    	return $filters->apply($query);
    }
}
