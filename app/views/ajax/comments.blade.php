
<? $count = 0; ?>

@foreach( $comments as $comment )
	<li class='comment' cid='{{ $comment->id }}'>

		<span class='comment-icon'><a href='#' class='comment-delete-link' cid='{{ $comment->id }}'>-</a></span>
		
		<div class='comment-text searchable'>
			<span style='padding-right: 13px;'>{{ $comment->comment }}</span>
			<span class='comment-date element-hoverable'>{{ $comment->created_at }}</span>
		</div>

		<div style='display: table-cell;'>
			<div class='comment-rating-stars element-hoverable'>
				
				{{-- first display correct number of comment ratings --}}
				@for( $i=0; $i< $comment->rating; $i++ )
					<img class='comment-rating-star' src='{{ url( "resources/rating.png" ) }}' />
				@endfor

				{{-- then display missing comment ratings --}}
				@for( $i=$comment->rating; $i<3; $i++ )
					<img class='comment-rating-star' src='{{ url( "resources/rating_none.png" ) }}' />
				@endfor
			</div>
		</div>

		<span class='comment-delete-confirm' cid='{{ $comment->id }}'>
			<button class='operator-button operator-button-confirm'>delete</button>
		</span>

	</li>

	@if( isset( $limit ) && ++$count >= 3 )
		<? break; ?>
	@endif

@endforeach

@if ( count( $comments ) == 0 )
	{{-- there are no comments -> show section to add a comment --}}
	<script type='text/javascript'>
		
		$jQ( function()
		{
			if ( typeof focusedElement === 'undefined' )
			{
				focusedElement = true;
				return showDiv( '#section-comment-add-{{ $stackr->id }}', 'textarea' );
			}
			else 
				return showDiv( '#section-comment-add-{{ $stackr->id }}' );
			
		});

	</script>
@endif