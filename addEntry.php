
<?php

	// read passed values
	$title = $_GET["title"];
	$desc = $_GET["description"];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// get next id
	$next_id = 1;
	
	if ( $result = $mysqli->query( "SELECT MAX(id) as m FROM entry" ) ) 
	{
		$row = $result->fetch_assoc();
		$next_id = $row['m'] + 1;

		$result->free();
	}

	// insert new entry
    $mysqli->query( "INSERT INTO entry (id,title,description) VALUES (".$next_id.", '".$title."', '".$desc."')" );

    $result->close();
	$mysqli->close();
?>