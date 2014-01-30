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

	$tagsAvailable = false;
	// print the distinct list of tags
	for ( $i=0; $i<count( $tagsDistinct ); $i++ )
	{
		if ( empty( $tagsDistinct[$i] ) )
			continue;
		
		$tagsAvailable = true; ?>
		<input type='checkbox' class='stackr-tag' id='tag_{{ $i }}'><label for='tag_{{ $i }}'>{{ $tagsDistinct[$i] }}</label>
<?	} ?>

	@if ( $tagsAvailable )
		<button class='operator-button' id='clearTags'>clear selection</button>
	@endif
 