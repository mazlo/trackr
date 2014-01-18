
@foreach( $contexts as $context )
	
	<li class='wrapper_context' cname='{{ $context->name }}'>
		<div class='context' style='background: {{ $context->color }};'>
			
			<a href='{{ url( "contexts/$context->name/stackrs" ) }}'>
				{{ $context->name }}
			</a>
			
			<ul class='list-contexts-stackrs'>
				@foreach( $context->stackrs as $stackr )
				<li>
					<a href='{{ url("contexts/$context->name/stackrs") }}'>#{{ $stackr->id }}</a>
				</li>
				@endforeach
			</ul>

		</div>

		<div class='context_add_options'>
			<button class='operatorButton operatorButton-narrow operatorButton-vertical context_delete_link'>x</button>
			<span class='context_delete_confirmation'>
				<button class='operatorButton confirmationButton' style='width: auto'>Sure?</button>
			</span>

			@foreach( $colors[ $context->name ] as $contextColors )
				<button class='operatorButton operatorButton-narrow operatorButton-vertical context_color_button' style='background: {{ $contextColors->color }}' color='{{ $contextColors->color }}'></button>
			@endforeach

			<button class='operatorButton operatorButton-narrow operatorButton-vertical context_color_button' style='background: #fff' color='#fff'></button>
		</div>
	</li>

@endforeach