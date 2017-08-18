@component('profiles.activities.activity')
	
	@slot('heading')
		{{ $profileUser->name }} favorited 
		<a href="{{ $activity->subject->favorited->path() }}">
			{{ $activity->subject->favorited->body }}
		</a>
	@endslot


	@slot('body')
		{{ $activity->subject->favorited->body }}
	@endslot('body')

@endcomponent