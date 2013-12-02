<?php

	// read passed values
	$entry_id = $_REQUEST["eid"];
	$tags = $_REQUEST["ts"];

	if ( empty( $entry_id ) || empty( $tags ) )
	{
		echo "<div>eid or tags parameter not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// update entry title
	$stmt = $mysqli->prepare( "UPDATE entry SET tags = ? WHERE id = ?" ); 
	$stmt->bind_param( 'si', $tags, $entry_id );
	$stmt->execute(); 
	
	$stmt->close();
	$mysqli->close();

	echo "done";
?>