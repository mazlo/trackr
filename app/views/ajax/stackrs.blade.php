@if ( count( $stackrs ) == 0 )
	<div class='wrapper_entry' style='padding: 13px 0;'>
		<p>Looks like you have no stackrs created yet.</p>
		<p>Click on the button above to create your first stackr!</p>
	</div>
@endif

@foreach( $stackrs as $stackr )
	<div id='{{ $stackr->id }}' class='wrapper_entry filterableByTag' tags='{{ $stackr->tags }}' eid='{{ $stackr->id }}'>

		<div class='entry_header'>
			
			<div class='entry_icon'>
				<span style='font-weight: bold'>#{{ $stackr->id }}</span>
			</div>

			<div class='entry_description'>
				<input class='textfield entry_title_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->title }}' disabled='disabled' />
				<span class='entry_title_confirm'>
					<button class='operator-button doneButton'>Done</button>
				</span>
				<h4 class='italic more_padding searchable'>{{ $stackr->description }}</h4>
			</div>

			<div class='entry_operations'>
				
				<button class='operator-button comment_add_link' eid='{{ $stackr->id }}'>add
					<span id='comment_add_button_text_{{ $stackr->id }}'>
						@if( substr( $stackr->listTitle, -1 ) == 's' ) 
							{{ substr( $stackr->listTitle, 0, -1 ) }} 
						@else 
							{{ $stackr->listTitle }}
						@endif
					</span>
				</button>

				<button class='operator-button entry_delete_link' eid='{{ $stackr->id }}'>delete Stackr</button>
				<span class='entry_delete_confirmation' eid='{{ $stackr->id }}'>
					<button class='operator-button operator-button-confirm'>delete</button>
				</span>

				<button class='operator-button entry_make_context_link' eid='{{ $stackr->id }}'>make Context</button>

			</div>

			<div class='entry_buttons'>
				<img src='{{ url( "resources/pinIt_$stackr->favored.png" ) }}' class='favoredIcon' alt='{{ $stackr->favored }}' width='28px' eid='{{ $stackr->id }}' />
			</div>

			<div style='clear: both; height: 0px'></div>

		</div>

		<div class='entry_content'>

			<!-- wrapper for all comments -->
			<div class='wrapper_comments'>
				<input class='textfield comments_title_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->listTitle }}' disabled='disabled' />
				<span class='comments_title_confirm'>
					<button class='operator-button doneButton'>Done</button>
				</span>
					
				<div class='comment_add_div' id='comment_add_link_{{ $stackr->id }}' style='display: none;'>
					<!-- div comment add: is hidden first -->
					<textarea id='comment_new_content_{{ $stackr->id }}' class='comment_textarea'></textarea>

					<div style='padding: 8px 0;'>
						<button class='operator-button comment_add_button' eid='{{ $stackr->id }}'>add</button>
						<button class='operator-button comment_add_cancel' eid='{{ $stackr->id }}'>cancel</button>
					</div>
				</div>

				<?php

					// sort stackr comments by position
					$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->get();
				?>

				<ul id='comments_{{ $stackr->id }}' class='comments'>
					@include( 'ajax.comments', array( 'limit' => 'true', 'comments' => $comments ) )
				</ul> 

				@if( count( $comments ) >= 3 )
					<p style='padding-left: 13px'>
						<a class='dotted seeMore' href=''>see more</a>
					</p>
				@endif
				
			</div>

		</div>

		<div class='entry_footer'>

			<div style='float: left'>
				<span style='color: #aaa;'>Tags:</span> 
				<input type='type' class='textfield tags_textfield_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->tags }}' disabled='disabled' /> 
			</div>

			{{-- 
			<div style='float: right; text-align: right'>
				<a href='{{ URL::to( "/contexts/$cname/stackrs/$stackr->id" ) }}' target='_self'>
					<button class='operator-button entry_details_link'>details</button>
				</a>
			</div>
			--}}

			<div style='clear: both;'></div>
		</div>

	</div> {{-- end of wrapper entry --}}
@endforeach