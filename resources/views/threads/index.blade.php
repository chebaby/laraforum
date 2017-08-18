@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h1>Forum Threads</h1>
					</div>
				</div>

				@forelse($threads as $thread)
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="level">
								<h4 class="flex">
									<a href="{{ $thread->path() }}">{{ $thread->title }}</a>
								</h4>
								<a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count )}}</a>
							</div>
						</div>

						<div class="panel-body">
							{{ $thread->body }}
						</div>
					</div>
				@empty
					<div class="alert alert-warning">
						<p>No threads</p>
					</div>
				@endforelse
			</div>
		</div>
	</div>


@endsection
