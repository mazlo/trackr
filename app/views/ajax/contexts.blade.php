
@foreach( $contexts as $context )
	
	<li class='context-wrapper' cname='{{ $context->name }}'>
		<div class='context element-shadow' style='background: {{ $context->color }}'>	
			<a href='{{ url( "contexts/$context->name/stackrs" ) }}'>
				{{ $context->name }}
			</a>
			
			<ul class='list-contexts-stackrs element-hoverable'>

				{{-- not the default query because we limit the size of children to 6 --}}
				@foreach( $context->stackrs()->getQuery()->limit(6)->get() as $key => $stackr )
				<li>
					@if ( $key == 5 )	{{-- means that the 6th element willl not be display --}}
						<a href='{{ url("contexts/$context->name/stackrs") }}'>...</a>
					@else
						<a href='{{ url("contexts/$context->name/stackrs") }}#{{ $stackr->id }}'>#{{ $stackr->id }}</a>
					@endif
				</li>
				@endforeach
			</ul>

		</div>

		<div class='context-options-box element-hoverable'>
			<button class='operator-button operator-button-narrow operator-button-vertical context_delete_link'>x</button>
			<span class='context-delete-confirm'>
				<button class='operator-button operator-button-confirm' style='width: auto'>delete</button>
			</span>

			@foreach( $colors[ $context->name ] as $contextColors )
				<button class='operator-button operator-button-narrow operator-button-vertical context_color_button' style='background: {{ $contextColors->color }}' color='{{ $contextColors->color }}'></button>
			@endforeach

			<button class='operator-button operator-button-narrow operator-button-vertical context_color_button' style='background: #fff' color='#fff'></button>
		</div>
	</li>

@endforeach
