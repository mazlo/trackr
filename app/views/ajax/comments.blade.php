
<?php

	// sort stackr comments by position
	if ( !isset( $comments ) )
		$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->get();

?>

<? $count = 0; ?>

@foreach( $comments as $comment )
	<li class='comment' cid='{{ $comment->id }}'>
		<span><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
		<span class='searchable'>{{ $comment->comment }}</span>
		<span class='comment_delete_confirmation' eid='{{ $stackr->id }}' cid='{{ $comment->id }}'>
			<button class='operator-button operator-button-confirm'>delete</button>
		</span>
	</li>

	@if( isset( $limit ) && ++$count >= 3 )
		<? break; ?>
	@endif

@endforeach