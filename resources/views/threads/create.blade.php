@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Create thread
					</div>

					<div class="panel-body">

					@if(count($errors))
						<div class="alert alert-danger">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</div>
					@endif
						
						<form action="/threads" method="POST" role="form">
							{{ csrf_field() }}
							
							<div class="form-group">
								<label for="channel_id">Channel:</label>
								<select name="channel_id" id="channel_id" class="form-control" required>
									<option value="">Choose channel...</option>
									@foreach($channels as $channel)
										<option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
											{{ $channel->name }}
										</option>
									@endforeach
								</select>
							</div>
						
							<div class="form-group">
								<label for="title">Title:</label>
								<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title') }}" required>
							</div>

							<div class="form-group">
								<label for="body">Body:</label>
								<textarea class="form-control" id="body" name="body" rows="5" placeholder="Start typing" required>{{ old('body') }}</textarea>
							</div>
						
							<button type="submit" class="btn btn-primary">Publish</button>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>


@endsection