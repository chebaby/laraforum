<?php

namespace App;

use App\Activity;

trait RecordsActivity
{
	// For any model that uses this trait, laravel tiriggers this method
	// exactly like if you created boot method in the model
	// convention boot[TraitName]
	protected static function bootRecordsActivity()
	{
		if(auth()->guest()) return;
		
		foreach(static::getActivitiesToRecord() as $event) {

			static::$event(function($model) use ($event) {
				$model->recordActivity($event);
			});
		}
	}


	protected static function getActivitiesToRecord()
	{
		return ['created'];
	}


	protected function recordActivity($event)
	{
		// Activity::create([
		// 	'type'         => $this->getActivityType($event), // i.e => created_thread
		// 	'user_id'      => auth()->id(),
		// 	'subject_id'   => $this->id,
		// 	'subject_type' => get_class($this) // i.e => App\Thread
		// ]);
		
		$this->activity()->create([

			'type'    => $this->getActivityType($event), // i.e => created_thread
			'user_id' => auth()->id()
			// 	'subject_id'   => Automaticly generated for us by the morphic relation
			// 	'subject_type' => Automaticly generated for us by the morphic relation
		]);
	}


	public function activity()
	{
		return $this->morphMany('App\Activity', 'subject');
	}


	protected function getActivityType($event)
	{
		$type = strtolower((new \ReflectionClass($this))->getShortName());

		return "{$event}_{$type}" ;
	}
}