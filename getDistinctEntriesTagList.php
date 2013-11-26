<?php

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// get all entries
    $result = $mysqli->query( "SELECT GROUP_CONCAT(DISTINCT tags SEPARATOR ', ') AS tags FROM entry " );
    $row = $result->fetch_assoc();

	$my = array();
	for( $i=0, $tags=split( ', ', $row['tags'] ); $i<count( $tags ); $i++ )
	{
		if ( !in_array( $tags[$i], $my ) )
			$my[] = $tags[$i];
	}

	for ( $i=0; $i<count($my); $i++ )
	{ ?>
	<input type="checkbox" class="entry_tag" id="<? echo $i; ?>"><label for="<? echo $i; ?>"><? echo $my[$i]; ?></label>
<? 	} 

	$result->close();
	$mysqli->close();
?>