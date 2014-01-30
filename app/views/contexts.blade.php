@extends( 'layout' )

@section( 'beforeContent' )
	<h3>Contexts</h3>
@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='section-context-add' class='section-context-add' style='display: none;'>

		<h4 class='georgia'>Name</h4>
		<span class='title-error credentials-error'></span>
		<input type='text' id='context-title' value='' class='textfield form' />
		
		<h4 class='italic'>Description</h4>
		<span class='description-error credentials-error'></span>
		<textarea id='context-description' class='textarea form'>Notes on the process</textarea>

		<div style='padding: 8px 0;'>
			<button class='operator-button context-add-action'>Add</button>
			<button class='operator-button context-add-cancel-action'>Cancel</button>
		</div>

	</div>

	<ul id='contexts'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</ul>

	<hr style='background: #bbb; border: 0; height: 1px; margin: 23px 0 32px' />

	<ul id='options' style='margin: 0; padding: 0; list-style-type: none;'>
		
		<li style='display: inline-block; padding-right: 62px'>
			<div class='context element-shadow'>
				<a href='' class='context-add' style='border: 0'>
					New Context
				</a>
			</div>
		</li>

		<li style='display: inline-block; vertical-align: top'>
			<div style='border: none;'>
				<h4 class='georgia'>You may want to</h4>
				<input type='checkbox' id='stackrs-organize' />
				<span>organize Stackrs</span>
			</div>
		</li>
	</ul>

@stop

@section( 'onDocumentLoad' )
	getContexts();

	$jQ( '#search' ).focus();
@stop