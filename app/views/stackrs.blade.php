@extends( 'layout' )

@section( 'topNavigation' )
	<nav>
		<ul id='menu'>
			<li>
				<a href='{{ url("/contexts") }}'>Contexts</a><img src='{{ url("resources/arrow_down.png") }}' style='width: 13px; margin-left: 3px' alt='' />
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
		<button class='button element-shadow stackr-add'>+ Stackr</button>
	</div>

	<div style='float: right; text-align: right; width: 700px'>

		<div id='stackrs-tag-list' style='display: inline;'>
			<!-- ajax response here -->
			<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px' alt='loading' />
		</div>
		
	</div>

@stop

@section( 'content' )

	<div id='section-stackr-add' class='section section-narrow section-hidden section-stackr-add'>

		<h3>New Stackr</h3>

		<input type='text' id='stackr-title' value='' class='textfield textfield-form-like form-element' placeholder='Title' />
		<textarea id='stackr-description' class='textarea form-element' placeholder='Description (optional), e.g. Notes on the process'></textarea>

		<div style='padding: 8px 0;'>
			<button class='operator-button stackr-add-action'>Add</button>
			<button class='operator-button stackr-add-next-action'>Add and add next</button>
			<button class='operator-button stackr-add-cancel-action'>Cancel</button>
		</div>

	</div>

	<!-- list of stackrs -->
	<div id='stackrs' cname='{{ $context->name }}'>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' />
	</div>

	<!-- dialog box -->
	<div id='context-make-confirm-dialog' style='display: none;'>

		<h4>At this point you might want to</h4>

		<ul style='padding-left: 23px'>
			<li style='margin-bottom: 13px'><i>create Context</i> <br />
				which will create a new Context and use the title and description from selected Stackr.</li>
			<li style='margin-bottom: 13px'><i>create Context and copy Stackr</i> <br />
				which will also <i>copy</i> the selected Stackr to the new Context.</li>
		</ul>
		
	</div>

	<!-- list of Stackrs to show -->
	<div id='section-stackrs-related' class='section-stackrs-related' sourceStackr=''>
		<!-- ajax response here -->
		<img src='{{ url( "resources/loader.gif" ) }}' style='width: 35px; padding-top: 13px;' alt='loading' />
	</div>

@stop

@section( 'onDocumentLoad' )
	getAllEntries();
	getDistinctEntriesTagList();
@stop