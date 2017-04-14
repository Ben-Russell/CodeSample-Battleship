
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
	
	<form method="POST" action="/game/join">
		
		{{ csrf_field() }}
		
		<h2>
			Join a Game:
		</h2>
		<div class="form-group row">
			<label for="GameID" class="col-sm-2 col-form-label">Game #:</label>
			<div class="col-sm-5">
				<input type="text" id="GameID" name="GameID" class="form-control" placeholder="Game #" />
			</div>
		</div>
		
		<button type="submit" class="btn btn-primary">Join</button>
	</form>

	<form method="POST" action="/game/create">
		
		{{ csrf_field() }}
		
		<h2>
			Create a Game:
		</h2>
		
		<button type="submit" class="btn btn-primary">Create</button>
	</form>
	
</div>

@endsection