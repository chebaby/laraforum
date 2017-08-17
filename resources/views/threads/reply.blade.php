<div class="panel panel-default">
	<div class="panel-heading">
		
		<div class="level">
			<h5 class="flex">
				<a href="#" title="{{ $reply->owner->name }}">{{ $reply->owner->name }}</a> 
				<strong>said</strong> {{ $reply->created_at->diffForHumans() }}...
			</h5>
			<form action="/replies/{{ $reply->id }}/favorites" method="POST" role="form">
				{{ csrf_field() }}

				<button type="submit" class="btn btn-default {{ $reply->favorited() ? 'disabled' : '' }}">
					{{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count()) }}
				</button>
				
			</form>
		</div>

	</div>
	<div class="panel-body">
		
		{{ $reply->body }}

	</div>
</div>