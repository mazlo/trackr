<?php

	// read passed values
	$entry_id = $_POST["eid"];
	$favored = $_POST["fv"];

	if ( empty( $entry_id ) || empty( $favored ) )
	{
		echo "<div>eid or favored parameter not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// update entry title
	$stmt = $mysqli->prepare( "UPDATE entry SET favored = ? WHERE id = ?" ); 
	$stmt->bind_param( 'ii', $favored, $entry_id );
	$stmt->execute(); 
	
	$stmt->close();
	$mysqli->close();

	echo "done";
?>