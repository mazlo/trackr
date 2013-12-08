@extends( 'layout' )

@section( 'beforeContent' )

	<div style="float: left">
		<button class="entry_add_link button">+ Stackr</button>
	</div>

	<div style="float: right; text-align: right; width: 700px">
		<div id="distinctEntriesTagList" style="display: inline;">
			<!-- ajax response here -->
		</div>
		<button class="operatorButton" id="clearTags">clear selection</button>
	</div>

	<div style="clear: both; height: 1px;"></div>

@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id="div_entry_add" class="div_entry_add" style="display: none; margin: 8px 0;">

		<h4 class="entry_new_title">Title</h4>
		<input type="text" id="title" value="" class="textfield" />
		
		<h4 class="entry_new_description">Description</h4>
		<textarea id="description" class="textarea"></textarea>

		<div style="padding: 8px 0;">
			<input type="button" class="entry_add_button" value="Add" />
			<input type="button" class="entry_add_cancel" value="Cancel" />
		</div>

	</div>

	<!-- list of entries -->
	<div id="entries" style="margin-top: 8px;">

		<ul>
		@foreach( $stackrs as $stackr )
			<li>{{ $stackr->title }}

			<ul id="comments_{{ $stackr->id }}" class="comments">
			@foreach( $stackr->comments as $comment )
				<li class='comment' cid='{{ $comment->id }}'>
					<span style="display: table-cell;"><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
					<span style="display: table-cell;" class="searchable">{{ $comment->comment }}</span>
					<span class="comment_delete_confirmation" eid='{{ $stackr->id }}' cid='{{ $comment->id }}'>
						<button class='operatorButton confirmationButton'>sure?</button>
					</span>
				</li>
			@endforeach
			</ul> 
		@endforeach
		</ul>
		
	</div>

@stop