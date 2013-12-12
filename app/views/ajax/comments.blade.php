@foreach( $stackr->comments as $comment )
	<li class='comment' cid='{{ $comment->id }}'>
		<span style='display: table-cell;'><a href='#' class='comment_delete_link' cid='{{ $comment->id }}'>-</a></span>
		<span style='display: table-cell;' class='searchable'>{{ $comment->comment }}</span>
		<span class='comment_delete_confirmation' eid='{{ $stackr->id }}' cid='{{ $comment->id }}'>
			<button class='operatorButton confirmationButton'>sure?</button>
		</span>
	</li>
@endforeach