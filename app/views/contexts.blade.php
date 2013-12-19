@extends( 'layout' )

@section( 'beforeContent' )

@stop

@section( 'content' )

	<div style='padding: 23px;'>
	@foreach( $contexts as $context )
		
		<a href='{{ url( "contexts/$context->name/stackrs" ) }}'>
			<div class='context'>
				{{ $context->name }}
			</div>
		</a>

	@endforeach
	</div>

@stop