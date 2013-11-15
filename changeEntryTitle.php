<?php

	// read passed values
	$entry_id = $_GET["eid"];
	$title = $_GET["tl"];

	if ( empty( $entry_id ) || empty( $title ) )
	{
		echo "<div>eid or title parameter not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// update entry title
	$stmt = $mysqli->prepare( "UPDATE entry SET title = ? WHERE id = ?" ); 
	$stmt->bind_param( 'si', $title, $entry_id );
	$stmt->execute(); 
	
	$stmt->close();
	$mysqli->close();

	echo "done";
?>