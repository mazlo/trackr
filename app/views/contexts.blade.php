@extends( 'layout' )

@section( 'beforeContent' )
	<h4 class='normal'>List of your Contexts</h4>
@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_context_add' class='div_context_add' style='display: none;'>

		<h4 class='context_new_title'>Name</h4>
		<input type='text' id='title' value='' class='textfield' />
		
		<h4 class='context_new_description'>Description</h4>
		<textarea id='description' class='textarea'></textarea>

		<div style='padding: 8px 0;'>
			<input type='button' class='context_add_button' value='Add' />
			<input type='button' class='context_add_cancel' value='Cancel' />
		</div>

	</div>

	<div id='contexts'>
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
	</div>

@stop