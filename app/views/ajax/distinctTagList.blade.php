<?php

	$tagsCS = $tagList[0]->tags; 	// comma separated list of tags
	$tagsDistinct = array();		// contains the distinct list of tags

	// creates the distinct list of tags
	for( $i=0, $tags=explode( ', ', $tagsCS ); $i<count( $tags ); $i++ )
	{
		// check if it already in list
		if ( !in_array( $tags[$i], $tagsDistinct ) )
			$tagsDistinct[] = $tags[$i];	// adds the tag to the list
	}

	// print the distinct list of tags
	for ( $i=0; $i<count($tagsDistinct); $i++ )
	{ ?>
		<input type='checkbox' class='entry_tag' id='{{ $i }}'><label for='{{ $i }}'>{{ $tagsDistinct[$i] }}</label>
<?	}
 