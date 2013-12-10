@extends( 'layout' )

@section( 'beforeContent' )

	<div style='float: left'>
		<button class='entry_add_link button'>+ Stackr</button>
	</div>

	<div style='float: right; text-align: right; width: 700px'>
		<div id='distinctEntriesTagList' style='display: inline;'>
			<!-- ajax response here -->
		</div>
		<button class='operatorButton' id='clearTags'>clear selection</button>
	</div>

	<div style='clear: both; height: 1px;'></div>

@stop

@section( 'content' )

	<!-- div entry add: is hidden after page load -->
	<div id='div_entry_add' class='div_entry_add' style='display: none; margin: 8px 0;'>

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
	<div id='entries' style='margin-top: 8px;'>

		@foreach( $stackrs as $stackr )
		<div class='wrapper_entry filterableByTag' tags='{{ $stackr->tags }}'>

			<div class='entry_header'>
				
				<div class='entry_icon'>
					<span style='font-weight: bold'>#{{ $stackr->id }}</span>
				</div>

				<div class='entry_description'>
					<input class='textfield entry_title_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->title }}' disabled='disabled' />
					<span class='entry_title_confirm'>
						<button class='operatorButton doneButton'>Done</button>
					</span>
					<h4 class='entry_description searchable'>{{ $stackr->description }}</h4>
				</div>

				<div class='entry_operations'>
					<button class='comment_add_link operatorButton' eid='{{ $stackr->id }}'>add
						<span id='comment_add_button_text_{{ $stackr->id }}'>
							@if( substr( $stackr->listTitle, -1 ) == 's' ) 
								{{ substr( $stackr->listTitle, 0, -1 ) }} 
							@else 
								{{ $stackr->listTitle }}
							@endif
						</span>
					</button>
					<button class='entry_delete_link operatorButton' eid='{{ $stackr->id }}'>delete Stackr</button>
					<span class='entry_delete_confirmation' eid='{{ $stackr->id }}'>
						<button class='operatorButton confirmationButton'>Sure?</button>
					</span>
				</div>

				<div class='entry_buttons'>
					<img src='resources/pinIt_{{ $stackr->favored }}.png' class='favoredIcon' alt='{{ $stackr->favored }}' width='28px' eid='{{ $stackr->id }}' />
				</div>

				<div style='clear: both; height: 0px'></div>

			</div>
			<div class='entry_content'>

				<!-- wrapper for all comments -->
				<div class='wrapper_comments'>
					<input class='textfield comments_title_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->listTitle }}' disabled='disabled' />
					<span class='comments_title_confirm'>
						<button class='operatorButton doneButton'>Done</button>
					</span>
						
					<div class='comment_add_div' id='comment_add_link_{{ $stackr->id }}' style='display: none;'>
						<!-- div comment add: is hidden first -->
						<textarea id='comment_new_content_{{ $stackr->id }}' class='comment_textarea'></textarea>

						<div style='padding: 8px 0;'>
							<button class='comment_add_button operatorButton' eid='{{ $stackr->id }}'>add</button>
							<button class='comment_add_cancel operatorButton' eid='{{ $stackr->id }}'>cancel</button>
						</div>
					</div>

					<ul id='comments_{{ $stackr->id }}' class='comments'>
					@foreach( $stackr->comments as $comment )
						<li class='comment' cid='{{ $comment->id }}'>
							<span style='display: table-cell;'><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
							<span style='display: table-cell;' class='searchable'>{{ $comment->comment }}</span>
							<span class='comment_delete_confirmation' eid='{{ $stackr->id }}' cid='{{ $comment->id }}'>
								<button class='operatorButton confirmationButton'>sure?</button>
							</span>
						</li>
					@endforeach
					</ul> 
				</div>

			</div>

			<div class='entry_footer'>

				<div style='float: left'>
					<span style='color: #aaa;'>Tags:</span> 
					<input type='type' class='textfield tags_textfield_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->tags }}' disabled='disabled' /> 
				</div>

				<div style='float: right; text-align: right'>
					<a href='entry.php?eid={{ $stackr->id }}'>
						<button class='entry_details_link operatorButton'>details</button>
					</a>
				</div>

				<div style='clear: both;'></div>
			</div>

		</div> {{-- end of wrapper entry --}}
	@endforeach
	</ul>

	</div>

@stop