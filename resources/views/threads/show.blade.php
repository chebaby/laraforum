@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">

		<div class="col-md-8">

			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> <strong>posted :</strong> {{ $thread->title }}
				</div>

				<div class="panel-body">
					
					{{ $thread->body }}

				</div>
			</div>

			@foreach($replies as $reply)
				@include('threads.reply')
			@endforeach

			{{ $replies->links() }}

			@if(auth()->check())
				<form action="{{ $thread->path() . '/replies'}}" method="POST" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea name="body" id="body" class="form-control" rows="5" required="required" placeholder="Have somthing to say?"></textarea>
					</div>

					<button type="submit" class="btn btn-primary">Post</button>
				</form>
			@else
				<p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion </p>
			@endif

		</div>

		<div class="col-md-4">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p>
						This thread was published <strong>{{ $thread->created_at->diffForHumans() }}</strong> 
						by  <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> 
						and has <strong>{{ $thread->replies_count }}</strong> {{ str_plural('comment', $thread->replies_count) }}
					</p>					
				</div>
			</div>

		</div>

	</div>
</div>


@endsection
