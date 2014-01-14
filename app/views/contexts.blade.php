@extends( 'layout' )

@section( 'beforeContent' )
	<h3>Contexts</h3>
@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_context_add' class='div_context_add' style='display: none;'>

		<h4 class='georgia'>Name</h4>
		<span id='title_error' class='credentials_error'></span>
		<input type='text' id='title' value='' class='textfield form' />
		
		<h4 class='italic'>Description</h4>
		<span id='description_error' class='credentials_error'></span>
		<textarea id='description' class='textarea form'>Notes on the process</textarea>

		<div style='padding: 8px 0;'>
			<button class='operator-button context_add_button'>Add</button>
			<button class='operator-button context_add_cancel'>Cancel</button>
		</div>

	</div>

	<ul id='contexts'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</ul>

	<hr style='background: #bbb; border: 0; height: 1px; margin: 23px 0 32px' />

	<div class='context'>
		<a href='' class='context_add_link' style='border: 0'>
			New Context
		</a>
	</div>

@stop

@section( 'onDocumentLoad' )
	getContexts();

	$jQ( '#search' ).focus();
@stop