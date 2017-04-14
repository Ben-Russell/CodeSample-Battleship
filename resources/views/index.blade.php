
@extends('layout')

@section('body')
<div class="container">
	
	<form method="POST" action="/game/join">
		<h2>
			Join a Game:
		</h2>
		<div class="form-group row">
			<label for="GameID" class="col-sm-2 col-form-label">Game #:</label>
			<div class="col-sm-5">
				<input type="text" id="GameID" class="form-control" placeholder="Game #" />
			</div>
		</div>
		
		<div class="form-group row">
			<label for="GamePassword" class="col-sm-2 col-form-label">Password:</label>
			<div class="col-sm-5">
				<input type="password" id="GamePassword" class="form-control" maxlength="50"/>
			</div>
		</div>
		
		<button type="submit" class="btn btn-primary">Join</button>
	</form>

	<form method="POST" action="/game/create">
		<h2>
			Create a Game:
		</h2>
		
		<div class="form-group row">
			<label for="GamePassword" class="col-sm-2 col-form-label">Password:</label>
			<div class="col-sm-5">
				<input type="password" id="GamePassword" class="form-control" maxlength="50"/>
			</div>
		</div>
		
		<button type="submit" class="btn btn-primary">Create</button>
	</form>
	
</div>

@endsection