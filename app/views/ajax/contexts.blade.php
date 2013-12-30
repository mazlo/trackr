
@foreach( $contexts as $context )
	
	<div class='wrapper_context' cname='{{ $context->name }}'>
		<div class='context'>
			<a href='{{ url( "contexts/$context->name/stackrs" ) }}' style='border: 0'>
				{{ $context->name }}
			</a>
		</div>

		<div style='display: table-cell; vertical-align: top'>
			<button class='operatorButton context_delete_link' style='min-width: 32px'>x</button>
			<span class='context_delete_confirmation'>
				<button class='operatorButton confirmationButton'>Sure?</button>
			</span>
		</div>
	</div>

@endforeach

	<hr style='background: #bbb; border: 0; height: 1px; margin: 23px 0 32px' />

	<div class='context'>
		<a href='' class='context_add_link' style='border: 0'>
			New Context
		</a>
	</div>