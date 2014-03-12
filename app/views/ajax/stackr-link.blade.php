<ul class='stackrs-related-list'>

@foreach( $contexts as $context )
	
	<li style='background-color: {{ $context->color }};'><span>{{ $context->name }}</span>

	<? $stackrs = $context->stackrs ?>
	@if( count( $stackrs ) > 0 )

		<ul>
		@foreach( $stackrs as $stackr )
			
			<li>
				<div>
					<img id='stackr-relatedTo-{{ $stackr->id }}' targetStackr='{{ $stackr->id }}' class='stackr-link-stackr operator-image operator-image-toggable' src='{{ url( "resources/link_0.png" ) }}' imgName='link' state='0' style='display: table-cell; width: 23px' />
					<label for='stackr-relatedTo-{{ $stackr->id }}' style='display: table-cell; padding-left: 8px;'>{{ $stackr->title }}</label>
				</div>
			</li>
		
		@endforeach
		</ul>

	@endif
@endforeach

	</li>

</ul>