
<?php

	// read passed values
	$entry_id = $_GET["entry_id"];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// delete
	$mysqli->query( 'DELETE FROM entry WHERE id = '. $entry_id );
	
	$result->close();
	$mysqli->close();
?>