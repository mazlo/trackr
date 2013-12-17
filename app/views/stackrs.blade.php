@extends( 'layout' )

@section( 'beforeContent' )

	<div style='float: left'>
		<button class='entry_add_link button'>+ Stackr</button>
	</div>

	<div style='float: right; text-align: right; width: 700px'>

		<div id='distinctEntriesTagList' style='display: inline;'>
			<!-- ajax response here -->
			<img src='resources/loader.gif' style='width: 35px' />
		</div>
		
	</div>

	<div style='clear: both; height: 1px;'></div>

@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_entry_add' class='div_entry_add' style='display: none;'>

		<h4 class='entry_new_title'>Title</h4>
		<input type='text' id='title' value='' class='textfield' />
		
		<h4 class='entry_new_description'>Description</h4>
		<textarea id='description' class='textarea'></textarea>

		<div style='padding: 8px 0;'>
			<input type='button' class='entry_add_button' value='Add' />
			<input type='button' class='entry_add_cancel' value='Cancel' />
		</div>

	</div>

	<!-- list of entries -->
	<div id='entries'>
		<!-- ajax response here -->
		<img src='resources/loader.gif' style='width: 35px' />
	</div>

@stop