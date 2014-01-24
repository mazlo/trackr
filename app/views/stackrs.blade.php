@extends( 'layout' )

@section( 'topNavigation' )
	<nav>
		<ul id='menu'>
			<li>
				<a href='{{ url("/contexts") }}'>Contexts</a><img src='{{ url("resources/arrow_down.png") }}' style='width: 13px; margin-left: 3px' />
				<ul>

				@foreach( $contexts as $contextItem )
					<li><a href='{{ url("/contexts/$contextItem->name/stackrs") }}'>{{ $contextItem->name }}</a></li>
				@endforeach

				</ul>
			</li>
		</ul>
	</nav>
@stop

@section( 'beforeContent' )

	<div style='float: left'>
		<button class='element-shadow entry_add_link button'>+ Stackr</button>
	</div>

	<div style='float: right; text-align: right; width: 700px'>

		<div id='distinctEntriesTagList' style='display: inline;'>
			<!-- ajax response here -->
			<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px' />
		</div>
		
	</div>

@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_entry_add' class='div_entry_add' style='display: none;'>

		<h4 class='georgia'>Title</h4>
		<input type='text' id='title' value='' class='textfield form' />
		
		<h4 class='italic'>Description</h4>
		<textarea id='description' class='textarea form'></textarea>

		<div style='padding: 8px 0;'>
			<button class='operator-button entry_add_button'>Add</button>
			<button class='operator-button entry_add_cancel'>Cancel</button>
		</div>

	</div>

	<!-- list of stackrs -->
	<div id='stackrs' cname='{{ $context->name }}'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</div>

	<!-- dialog box -->
	<div id='context-make-confirm-dialog' style='display: none; font-family: AleoLight'>

		<h4>At this point you might want to</h4>

		<ul style='padding-left: 23px'>
			<li style='margin-bottom: 13px'><i>create Context</i> <br />
				which will create a new Context and use the title and description from selected Stackr.</li>
			<li style='margin-bottom: 13px'><i>create Context and copy Stackr</i> <br />
				which will also <i>copy</i> the selected Stackr to the new Context.</li>
		</ul>
		
	</div>

@stop

@section( 'onDocumentLoad' )
	getAllEntries();
	getDistinctEntriesTagList();

	$jQ( '#search' ).focus();
@stop