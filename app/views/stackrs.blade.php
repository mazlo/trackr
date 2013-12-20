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

		<h4 class='georgia'>Title</h4>
		<input type='text' id='title' value='' class='textfield form' />
		
		<h4 class='italic'>Description</h4>
		<textarea id='description' class='textarea form'></textarea>

		<div style='padding: 8px 0;'>
			<button class='entry_add_button operatorButton'>Add</button>
			<button class='entry_add_cancel operatorButton'>Cancel</button>
		</div>

	</div>

	<!-- list of entries -->
	<div id='entries' cnid='{{ $cnid }}'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</div>

@stop

@section( 'onDocumentLoad' )
	getAllEntries();
	getDistinctEntriesTagList();

	$jQ( '#search' ).focus();
@stop