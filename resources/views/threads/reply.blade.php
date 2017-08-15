<div class="panel panel-default">
	<div class="panel-heading">
		<a href="#" title="{{ $reply->owner->name }}">{{ $reply->owner->name }}</a> 
		<strong>said</strong> {{ $reply->created_at->diffForHumans() }}...
	</div>
	<div class="panel-body">
		
		{{ $reply->body }}

	</div>
</div>