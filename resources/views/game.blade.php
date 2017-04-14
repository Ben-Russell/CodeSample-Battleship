
@extends('layout')

@section('body')
<div class="container">
	
	Game # {{ $game->GameID }} -
	{{ $player->Color ? 'Red' : 'Blue' }} Player
	
	@for ($y=9; $y>=0; $y--)
		<div class="row">
			@for ($x=0; $x<=9; $x++)
				<div class="boardsquare col-sm-1">
					@php
						$shot = $shots->where('PositionX', $x)->where('PositionY', $y)->get();
					@endphp
					@if ($shot->count())
						@if ($shot->first()->IsHit)
							<button type="submit" class="btn btn-danger">X</button>
						@else
							<button type="submit" class="btn btn-secondary">O</button>
						@endif
					@else
						<button type="submit" class="btn btn-primary"></button>
					@endif

				</div>
			@endfor
		</div>
	@endfor
	
</div>

@endsection