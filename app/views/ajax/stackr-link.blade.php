<ul class='stackrs-related-list'>

@foreach( $contexts as $context )
	
	<li style='background-color: {{ $context->color }};'><span>{{ $context->name }}</span>

	<? $stackrs = $context->stackrs ?>
	@if( count( $stackrs ) > 0 )

		<ul>
		@foreach( $stackrs as $stackr )
			
			<li>
				<div>
					<input id='stackr-link-{{ $stackr->id }}' type='radio' name='stackr-link' value='{{ $stackr->id }}' style='display: table-cell' />
					<label for='stackr-link-{{ $stackr->id }}' style='display: table-cell; padding-left: 8px;'>{{ $stackr->title }}</label>
				</div>
			</li>
		
		@endforeach
		</ul>

	@endif
@endforeach

	</li>

</ul>