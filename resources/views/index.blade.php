
@extends('layout')

@section('body')
<div class="container">
	
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form method="POST" action="/game/create">
		
		{{ csrf_field() }}
		
		<h2>
			Start a Game:
		</h2>
		
		<button type="submit" class="btn btn-primary">Start</button>
	</form>
	
</div>

@endsection