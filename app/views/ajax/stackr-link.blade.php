<ul style='list-style-type: none; margin: 0; padding: 0; font-size: 13px'>

@foreach( $contexts as $context )
	
	<li style='margin: 4px 0 0; padding: 2px 0'>{{ $context->name }}</li>

	<? $stackrs = $context->stackrs ?>
	@if( count( $stackrs ) > 0 )

		<ul style='list-style-type: none; margin: 0 13px; padding: 0'>
		@foreach( $stackrs as $stackr )
			
			<li style='padding: 2px 0'>
				<input id='stackr-link-{{ $stackr->id }}' type='radio' name='stackr-link' value='{{ $stackr->id }}' />
				<label for='stackr-link-{{ $stackr->id }}'>{{ $stackr->title }}</label>
			</li>
		
		@endforeach
		</ul>

	@endif
@endforeach

</ul>