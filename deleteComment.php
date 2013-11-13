
<?php

	// read passed values
	$entry_id = $_GET['eid'];
	$comment_id = $_GET['cid'];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// delete
	$mysqli->query( 'DELETE FROM comment WHERE entry_id = '. $entry_id .' and id = '. $comment_id );
	
	$result->close();
	$mysqli->close();
?>