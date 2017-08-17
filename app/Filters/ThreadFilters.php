<?php

namespace App\Filters;

use App\User;
use App\Filters\Filters;

class ThreadFilters extends Filters
{

	protected $filters = ['by', 'popular'];


	protected function by($username)
	{
		$user = User::where('name', $username)->firstOrFail();
		
		return $this->builder->where('user_id', $user->id);
	}


	protected function popular()
	{
		// explicitly clear out any other orders that has been set
		$this->builder->getQuery()->orders = [];
		// so ower order by replies_count take presidency
		return $this->builder->orderBy('replies_count', 'desc');
	}
}