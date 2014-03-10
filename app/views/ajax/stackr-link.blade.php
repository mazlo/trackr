<ul style='list-style-type: none; margin: 0; padding: 0'>

@foreach( $contexts as $context )
	
	<li style='margin: 4px 0 0; padding: 2px 0'>{{ $context->name }}</li>

	<? $stackrs = $context->stackrs ?>
	@if( count( $stackrs ) > 0 )

		<ul style='list-style-type: none; margin: 0 13px; padding: 0'>
		@foreach( $stackrs as $stackr )
			
			<li style='padding: 2px 0'>{{ $stackr->title }}</li>
		
		@endforeach
		</ul>

	@endif
@endforeach

</ul>