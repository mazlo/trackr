
<?php

	// sort stackr comments by position
	if ( !isset( $comments ) )
		$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->get();

?>

<? $count = 0; ?>

@foreach( $comments as $comment )
	<li class='comment' cid='{{ $comment->id }}'>
		<span style='display: table-cell;'><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
		<span style='display: table-cell;' class='searchable'>{{ $comment->comment }}</span>
		<span class='comment_delete_confirmation' eid='{{ $stackr->id }}' cid='{{ $comment->id }}'>
			<button class='operatorButton confirmationButton'>sure?</button>
		</span>
	</li>

	@if( isset( $limit ) && ++$count >= 3 )
		<? break; ?>
	@endif

@endforeach