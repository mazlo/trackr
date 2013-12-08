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

@section( 'stackrs' )

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

@stop