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
	<div id='{{ $stackr->id }}' class='stackr-wrapper stackr-filterable-by-tag' tags='{{ $stackr->tags }}' relatedTo='{{ $stackr->relatedTo }}'>

		<div class='stackr-header'>
			
			<div class='stackr-icon'>
				<span style='font-weight: bold'>#{{ $stackr->id }}</span>
			</div>

			<div class='stackr-description'>
				<input class='textfield textfield-title' value='{{ $stackr->title }}' disabled='disabled' />
				<button class='operator-button operator-button-done'>done</button>
				<h4 class='italic more-padding searchable'>{{ $stackr->description }}</h4>
			</div>

			<div class='stackr-operations section-hoverable'>

				<div>				
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

					<button class='operator-button stackr-make-context-link'>make Context</button>
				</div>

				<div>
					<img class='stackr-filter-tasks operator-image operator-image-toggable' src='{{ url( "resources/edit_0.png" ) }}' imgName='edit' state='0' alt='edit' />
					<img class='stackr-show-dates operator-image operator-image-toggable' src='{{ url( "resources/calendar_0.png" ) }}' imgName='calendar' state='0' alt='cal' />
					
					<img class='stackr-email operator-image operator-image-toggable' src='{{ url( "resources/mail_0.png" ) }}' imgName='mail' state='0' alt='mail' />
					<button class='operator-button operator-button-done'>email sent</button>
					<img class='operator-image operator-loading-image element-hidden' src='{{ url( "resources/loader.gif" ) }}' style='width: 23px' alt='loading' />

					<img class='stackr-bookmark operator-image operator-image-toggable' src='{{ url( "resources/bookmark_$stackr->favored.png" ) }}' imgName='bookmark' state='{{ $stackr->favored }}' alt='mark' />
				</div>
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
					<img class='operator-image operator-image-toggable' src='{{ url( "resources/edit_0.png" ) }}' imgName='edit' state='0' style='float: left' alt='edit' />

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
						
						<div>
							<img id='comments-loader-img-{{ $stackr->id }}' src='{{ url( "resources/loader.gif" ) }}' style='display: none; width: 35px' alt='loading' />
							<a class='dotted link-see-more' href=''>see more ({{ count( $comments ) }} in total)</a>
						</div>

					</li>
				@endif
			
				</ul> 
				
			</div>

		</div>

		<div class='stackr-footer'>
			
			<div class='stackr-footer-tags'>
				<span style='color: #aaa;'>Tags:</span> 
				<input type='type' class='textfield textfield-form-like textfield-limited textfield-tags-inactive' value='{{ $stackr->tags }}' disabled='disabled' /> 
			</div>

			<div class='stackr-footer-relation'>
				<span id='stackr-related-to-snippet-{{ $stackr->id }}'>
				@if( isset( $stackr->relatedTo ) && $stackr->relatedTo != 0 )
					<? 
						// retrieve the related Stackr
						$relatedStackr = $stackrRelation[ 'for-' . $stackr->id ];
					?>

					@include( 'ajax.snippets.relatedTo', array( 'stackr' => $stackr, 'relatedStackr' => $relatedStackr ) )

				@endif
				</span>

				<img class='stackr-related-stackrs operator-image operator-image-toggable' src='{{ url( "resources/related_0.png" ) }}' relatedTo='{{ $stackr->relatedTo }}' imgName='related' state='0' alt='rel' />
			
			</div>

		</div>

	</div> {{-- end of wrapper entry --}}
@endforeach