@extends( 'layout' )

@section( 'beforeContent' )

	<h3 style='margin: 0'>Showing You Details for Stackr</h3>

@stop

@section( 'content' )

	<div class='wrapper_entry filterableByTag' tags='{{ $stackr->tags }}' eid='{{ $stackr->id }}'>

		<div class='entry_header'>
			
			<div class='entry_icon'>
				<span style='font-weight: bold'>#{{ $stackr->id }}</span>
			</div>

			<div class='entry_description'>
				<input class='textfield entry_title_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->title }}' disabled='disabled' />
				<span class='entry_title_confirm'>
					<button class='operator-button doneButton'>Done</button>
				</span>
				<h4 class='entry_description searchable'>{{ $stackr->description }}</h4>
			</div>

			<div class='entry_operations'>
				<button class='comment_add_link operator-button' eid='{{ $stackr->id }}'>add
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
					<button class='operator-button operator-button-confirm'>Sure?</button>
				</span>
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

				<ul id='comments_{{ $stackr->id }}' class='comments'>
					@include( 'ajax.comments' )
				</ul> 
			</div>

		</div>

		<div class='entry_footer'>

			<div style='float: left'>
				<span style='color: #aaa;'>Tags:</span> 
				<input type='type' class='textfield tags_textfield_inactive' eid='{{ $stackr->id }}' value='{{ $stackr->tags }}' disabled='disabled' /> 
			</div>

			<div style='clear: both;'></div>
		</div>

	</div> {{-- end of wrapper entry --}}
@stop

@section( 'onDocumentLoad' )
	$jQ( '#search' ).focus();
@stop