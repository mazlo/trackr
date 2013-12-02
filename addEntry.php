
<?php

	// read passed values
	$title = $_REQUEST["title"];
	$desc = $_REQUEST["description"];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// insert new entry
    $mysqli->query( "INSERT INTO entry (id,title,description) VALUES (default, '".$title."', '".$desc."')" );
	$mysqli->close();
?>