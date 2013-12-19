
@foreach( $contexts as $context )
		
	<a href='{{ url( "contexts/$context->name/stackrs" ) }}'>
		<div class='context'>
			{{ $context->name }}
		</div>
	</a>

@endforeach

	<a href='' class='context_add_link'>
		<div class='context'>
			New Context
		</div>
	</a>