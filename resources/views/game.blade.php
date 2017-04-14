
@extends('layout')

@section('body')
<div class="container">
	
	Game # {{ $game->GameID }} -
	{{ $player->Color ? 'Red' : 'Blue' }} Player
	
	@if( session('shotResult') )
		@if( session('shotResult') == 'hit' )
			<div class="alert alert-success">
				You have hit a ship!
			</div>
		@else
			<div class="alert alert-warning">
				You have missed!
			</div>
		@endif
	@endif
	
	@if( session('computerResult') )
		@if( session('computerResult') == 'hit' )
			<div class="alert alert-danger">
				One of your ships have been hit!
			</div>
		@else
			<div class="alert alert-success">
				The enemy shot misses your ships!
			</div>
		@endif
	@endif
	
	
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form id="GameBoard" method="POST" action="/game/shoot">
		
		{{ csrf_field() }}
		
		<input type="hidden" id="PositionX" name="positionx" value="0"/>
		<input type="hidden" id="PositionY" name="positiony" value="0"/>
	
		@for ($y=9; $y>=0; $y--)
			<div class="row">
				@for ($x=0; $x<=9; $x++)
					<div class="boardsquare col-sm-1">
						@php
							$shot = $shots->where('PositionX', $x)->where('PositionY', $y);
						@endphp
						@if ($shot->count())
							@if ($shot->first()->IsHit)
								<button type="button" class="btn btn-danger" disabled>X</button>
							@else
								<button type="button" class="btn btn-secondary" disabled>O</button>
							@endif
						@else
							<button type="button" class="btn btn-primary" data-x="{{ $x }}" data-y="{{ $y }}"></button>
						@endif

					</div>
				@endfor
			</div>
		@endfor

	</form>

	<a href="/">< Home</a>
	
</div>

<script type="text/javascript">

	(function() {
		
		window.onload = function OnLoad() {
			document.getElementById('GameBoard')
				.addEventListener('click', function(event) {
					if(event.target.tagName == "BUTTON") {
						var x = event.target.getAttribute('data-x');
						var y = event.target.getAttribute('data-y');
						
						document.getElementById('PositionX').value = x;
						document.getElementById('PositionY').value = y;
						
						document.getElementById('GameBoard').submit();
					}
				}, false);
			
			
		};
		
	})();
	
</script>

@endsection