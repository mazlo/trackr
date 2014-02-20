@if ( count( $stackrs ) == 0 )
	<div class='stackr-wrapper' style='padding: 13px 0;'>
		<p>A list of Stackrs will be shown here.</p>
		<p>Looks like you have no stackrs created yet.</p>
	</div>

	<script type='text/javascript'>
		$jQ( function()
		{
			return showDiv( '#section-stackr-add', '.textfield' );
		});
	</script>
@endif

@foreach( $stackrs as $stackr )
	<div id='{{ $stackr->id }}' class='stackr-wrapper stackr-filterable-by-tag' tags='{{ $stackr->tags }}'>

		<div class='stackr-header'>
			
			<div class='stackr-icon'>
				<span style='font-weight: bold'>#{{ $stackr->id }}</span>
			</div>

			<div class='stackr-description'>
				<input class='textfield textfield-title' value='{{ $stackr->title }}' disabled='disabled' />
				<button class='operator-button operator-button-done'>done</button>
				<h4 class='italic more_padding searchable'>{{ $stackr->description }}</h4>
			</div>

			<div class='stackr-operations section-hoverable'>
				
				<button class='operator-button comment-add'>add
					<span id='comment_add_button_text_{{ $stackr->id }}'>
						@if( substr( $stackr->listTitle, -1 ) == 's' ) 
							{{ substr( $stackr->listTitle, 0, -1 ) }} 
						@else 
							{{ $stackr->listTitle }}
						@endif
					</span>
				</button>

				<button class='operator-button stackr-delete-link'>delete Stackr</button>
				<span class='stackr-delete-confirm'>
					<button class='operator-button operator-button-confirm'>delete</button>
				</span>

				<button class='operator-button entry_make_context_link'>make Context</button>

				<button class='operator-button stackr-filter-tasks operator-button-toggable operator-button-state-default'>filter tasks</button>
			</div>

			<div class='stackr-buttons section-hoverable'>
				<img src='{{ url( "resources/pinIt_$stackr->favored.png" ) }}' class='favoredIcon' alt='{{ $stackr->favored }}' width='28px' />
			</div>

		</div>

		<div class='stackr-content'>

			<!-- wrapper for all comments -->
			<div class='comments-wrapper'>

				<input class='textfield textfield-limited textfield-comments-title' value='{{ $stackr->listTitle }}' disabled='disabled' />
				<button class='operator-button operator-button-done'>done</button>
					
				<!-- div comment add: is hidden first -->
				<div class='section-comment-add section-hidden' id='section-comment-add-{{ $stackr->id }}'>

					<textarea style='float: left' id='comment-add-{{ $stackr->id }}' class='textarea textarea-comment' placeholder='This is the place where you may state anything about "{{ $stackr->title }}"'></textarea>
					<button style='float: right' class='operator-button operator-button-toggable'>is task</button>

					<div style='clear: both; padding: 8px 0;'>
						<button class='operator-button comment-add-action'>Add</button>
						<button class='operator-button comment-add-next-action'>Add and add next</button>
						<button class='operator-button comment-add-cancel-action'>Cancel</button>
					</div>
				</div>

				<?php

					// sort stackr comments by position
					$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->orderBy( 'created_at', 'desc' )->get();
				?>

				<ul id='comments-{{ $stackr->id }}' class='comments'>
			
				@include( 'ajax.comments', array( 'limit' => 'true', 'comments' => $comments, 'stackr' => $stackr ) )

				@if( count( $comments ) > 3 )
					<li class='comment-see-more'>
						<img id='comments-loader-img-{{ $stackr->id }}' src='{{ url( "resources/loader.gif" ) }}' style='display: none; width: 35px' />
						<a class='dotted link-see-more' href=''>see more ({{ count( $comments ) }} in total)</a>
					</li>
				@endif
			
				</ul> 
				
			</div>

		</div>

		<div class='stackr-footer'>
			<span style='color: #aaa;'>Tags:</span> 
			<input type='type' class='textfield textfield-form-like textfield-limited textfield-tags-inactive' value='{{ $stackr->tags }}' disabled='disabled' /> 
		</div>

	</div> {{-- end of wrapper entry --}}
@endforeach