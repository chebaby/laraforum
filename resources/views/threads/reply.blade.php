<reply :attributes="{{ $reply }}" inline-template v-cloak>
	
	<div class="panel panel-default" id="reply-{{ $reply->id }}">
		<div class="panel-heading">
			
			<div class="level">
				<h5 class="flex">
					<a href="{{ route('profile', $thread->owner) }}" title="{{ $reply->owner->name }}">{{ $reply->owner->name }}</a> 
					<strong>said</strong> {{ $reply->created_at->diffForHumans() }}...
				</h5>
				<form action="/replies/{{ $reply->id }}/favorites" method="POST" role="form">
					{{ csrf_field() }}

					<button type="submit" class="btn btn-default" {{ $reply->favorited() ? 'disabled' : '' }}>
						{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
					</button>
					
				</form>
			</div>

		</div>

		<div class="panel-body">
			<div v-if="editing">
				<div class="form-group">
					<textarea class="form-control" v-model="body"></textarea>
				</div>

				<button type="button" class="btn btn-xs btn-primary" @click="update">Update</button>
				<button type="button" class="btn btn-xs btn-link" @click="editing = false">cancel</button>
			</div>

			<div v-else v-text="body"></div>
		</div>
		
		@can('delete', $reply)
			<div class="panel-footer level">
				<button class="btn btn-default btn-xs mr-1" @click="editing = true">Edit</button>
				<form action="/replies/{{ $reply->id }}" method="POST" role="form">
					{{ csrf_field() }}
					{{ method_field('delete') }}
				
					<button type="submit" class="btn btn-danger btn-xs">Delete</button>
				</form>
			</div>
		@endcan
	</div>

</reply>