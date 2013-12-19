@extends( 'layout' )

@section( 'beforeContent' )
	<h3>Contexts</h3>
@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_context_add' class='div_context_add' style='display: none;'>

		<h4 class='context_new_title'>Name</h4>
		<input type='text' id='title' value='' class='textfield' />
		
		<h4 class='context_new_description'>Description</h4>
		<textarea id='description' class='textarea'></textarea>

		<div style='padding: 8px 0;'>
			<button class='context_add_button operatorButton'>Add</button>
			<button class='context_add_cancel operatorButton'>Cancel</button>
		</div>

	</div>

	<div id='contexts'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</div>

@stop

@section( 'onDocumentLoad' )
	getContexts();

	$jQ( '#search' ).focus();
@stop