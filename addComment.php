<?php

	// read passed values
	$entryId = $_REQUEST["eid"];
	$comment = $_REQUEST["comment"];

	if ( empty( $entryId ) || empty( $comment ) ) 
	{
		echo "<div>eid or comment parameter not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// insert new entry
    $mysqli->query( "INSERT INTO comment (id,entry_id,comment) VALUES (default, ".$entryId.", '".$comment."')" );
	$mysqli->close();

	echo "done";
?>