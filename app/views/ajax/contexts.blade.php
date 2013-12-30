
@foreach( $contexts as $context )
	
	<div class='wrapper_context'>
		<div class='context'>
			<a href='{{ url( "contexts/$context->name/stackrs" ) }}' style='border: 0'>
					{{ $context->name }}
			</a>
		</div>

		<div style='display: table-cell; vertical-align: top'>
			
		</div>
	</div>

@endforeach

	<hr style='background: #bbb; border: 0; height: 1px; margin: 23px 0 32px' />

	<div class='context'>
		<a href='' class='context_add_link'>
			New Context
		</a>
	</div>