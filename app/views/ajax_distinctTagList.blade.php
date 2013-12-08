<?php

	$my = array();
	for( $i=0, $tags=explode( ', ', $tagList[0]->tags ); $i<count( $tags ); $i++ )
	{
		if ( !in_array( $tags[$i], $my ) )
			$my[] = $tags[$i];
	}

	for ( $i=0; $i<count($my); $i++ )
	{ ?>
		<input type='checkbox' class='entry_tag' id='{{ $i }}'><label for='{{ $i }}'>{{ $my[$i] }}</label>
<?	}
 