<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

	protected $guarded = [];


    public function replies()
	{
		return $this->hasMany(Reply::class);
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
}
