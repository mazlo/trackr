
<?php

	// sort stackr comments by position
	if ( !isset( $comments ) )
		$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->get();

?>

<? $count = 0; ?>

@foreach( $comments as $comment )
	<li class='comment' cid='{{ $comment->id }}'>

		<span class='comment-icon'><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
		
		<div class='comment-text searchable'>
			<span style='padding-right: 13px;'>{{ $comment->comment }}</span>
			<span class='comment-date'>{{ $comment->created_at }}</span>
		</div>

		<div style='display: table-cell;'>
			<div class='comment-rating-stars'>
				<img class='comment-rating-star' src='{{ url( "resources/rating_none.png" ) }}' />
				<img class='comment-rating-star' src='{{ url( "resources/rating_none.png" ) }}' />
				<img class='comment-rating-star' src='{{ url( "resources/rating_none.png" ) }}' />
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