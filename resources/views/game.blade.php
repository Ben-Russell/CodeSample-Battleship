
@extends('layout')

@section('body')
<div class="container">
	
	Game # {{ $game->GameID }} -
	{{ $player->Color ? 'Red' : 'Blue' }} Player
	
	@for ($y=9; $y>=0; $y--)
		<div class="row">
			@for ($x=0; $x<=9; $x++)
				<div class="col-sm-1">
				
				</div>
			@endfor
		</div>
	@endfor
	
</div>

@endsection