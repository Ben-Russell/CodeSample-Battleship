
@extends('layout')

@section('body')
<div class="container">
	@if ( session('result') == 'win' )
		<h1>
			You have Won!
		</h1>
	@else
		<h1>
			You have lost!	
		</h1>
	@endif
	
	<a href="/">Play Again</a>

@endsection