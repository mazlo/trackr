@if ( count( $stackrs ) == 0 )
	<div class='stackr-wrapper' style='padding: 13px 0;'>
		<p>Looks like you have no stackrs created yet.</p>
		<p>Click on the button above to create your first stackr!</p>
	</div>
@endif

@foreach( $stackrs as $stackr )
	<div id='{{ $stackr->id }}' class='stackr-wrapper filterableByTag' tags='{{ $stackr->tags }}'>

		<div class='stackr-header'>
			
			<div class='stackr-icon'>
				<span style='font-weight: bold'>#{{ $stackr->id }}</span>
			</div>

			<div class='stackr-description'>
				<input class='textfield textfield-title' value='{{ $stackr->title }}' disabled='disabled' />
				<span class='entry_title_confirm'>
					<button class='operator-button operator-button-done'>done</button>
				</span>
				<h4 class='italic more_padding searchable'>{{ $stackr->description }}</h4>
			</div>

			<div class='stackr-operations'>
				
				<button class='operator-button comment_add_link'>add
					<span id='comment_add_button_text_{{ $stackr->id }}'>
						@if( substr( $stackr->listTitle, -1 ) == 's' ) 
							{{ substr( $stackr->listTitle, 0, -1 ) }} 
						@else 
							{{ $stackr->listTitle }}
						@endif
					</span>
				</button>

				<button class='operator-button entry_delete_link'>delete Stackr</button>
				<span class='entry_delete_confirmation'>
					<button class='operator-button operator-button-confirm'>delete</button>
				</span>

				<button class='operator-button entry_make_context_link'>make Context</button>

			</div>

			<div class='stackr-buttons'>
				<img src='{{ url( "resources/pinIt_$stackr->favored.png" ) }}' class='favoredIcon' alt='{{ $stackr->favored }}' width='28px' />
			</div>

		</div>

		<div class='stackr-content'>

			<!-- wrapper for all comments -->
			<div class='comments-wrapper'>
				<input class='textfield textfield-comments-title' value='{{ $stackr->listTitle }}' disabled='disabled' />
				<span class='comments_title_confirm'>
					<button class='operator-button operator-button-done'>done</button>
				</span>
					
				<div class='comment_add_div' id='comment_add_link_{{ $stackr->id }}' style='display: none;'>
					<!-- div comment add: is hidden first -->
					<textarea id='comment_new_content_{{ $stackr->id }}' class='textarea textarea-comment'></textarea>

					<div style='padding: 8px 0;'>
						<button class='operator-button comment_add_button'>add</button>
						<button class='operator-button comment_add_cancel'>cancel</button>
					</div>
				</div>

				<?php

					// sort stackr comments by position
					$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->get();
				?>

				<ul id='comments_{{ $stackr->id }}' class='comments'>
					@include( 'ajax.comments', array( 'limit' => 'true', 'comments' => $comments ) )
				</ul> 

				@if( count( $comments ) > 3 )
					<p style='padding-left: 13px'>
						<a class='dotted seeMore' href=''>see more</a>
					</p>
				@endif
				
			</div>

		</div>

		<div class='stackr-footer'>
			<span style='color: #aaa;'>Tags:</span> 
			<input type='type' class='textfield tags_textfield_inactive' value='{{ $stackr->tags }}' disabled='disabled' /> 
		</div>

	</div> {{-- end of wrapper entry --}}
@endforeach