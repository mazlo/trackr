## {{ $stackr->title }} ## <br/><br/>

_{{ $stackr->description }}_ <br/><br/>

### {{ $stackr->listTitle }} ### <br/><br/>

<?php

	// sort stackr comments by position and date
	$comments = $stackr->comments()->getQuery()->orderBy( 'position' )->orderBy( 'created_at', 'desc' )->get();
?>

@foreach( $comments as $comment )
	**{{ $comment->created_at }}** <br/>
	
	{{ $comment->comment }} <br/><br/>

@endforeach

// this is suppossed to be markdown syntax