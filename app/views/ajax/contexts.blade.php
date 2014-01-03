
@foreach( $contexts as $context )
	
	<div class='wrapper_context' cname='{{ $context->name }}'>
		<div class='context' style='background: {{ $context->color }}'>
			<a href='{{ url( "contexts/$context->name/stackrs" ) }}' style='border: 0'>
				{{ $context->name }}
			</a>
		</div>

		<div class='context_add_options'>
			<button class='operatorButton operatorButton-narrow operatorButton-vertical context_delete_link'>x</button>
			<span class='context_delete_confirmation'>
				<button class='operatorButton confirmationButton' style='width: auto'>Sure?</button>
			</span>

			@foreach( $colors[ $context->name ] as $contextColors )
				<button class='operatorButton operatorButton-narrow operatorButton-vertical context_color_button' style='background: {{ $contextColors->color }}' color='{{ $contextColors->color }}'></button>
			@endforeach

			<button class='operatorButton operatorButton-narrow operatorButton-vertical context_color_button' style='background: #fff' color='#fff'>w/o</button>
		</div>
	</div>

@endforeach

	<hr style='background: #bbb; border: 0; height: 1px; margin: 23px 0 32px' />

	<div class='context'>
		<a href='' class='context_add_link' style='border: 0'>
			New Context
		</a>
	</div>