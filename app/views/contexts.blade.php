@extends( 'layout' )

@section( 'beforeContent' )

@stop

@section( 'content' )

	<div style='padding: 23px;'>
	@foreach( $contexts as $context )
		
		<div class='context'>
			{{ $context->name }}
		</div>

	@endforeach
	</div>

@stop