<?php

	session_start();

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$session_userid = $_SESSION[ 'userid' ];
	$result = $mysqli->query( "SELECT id FROM user WHERE username = '$session_userid'" );
	$row = $result->fetch_assoc();

	$userid = $row['id'];

	if( !isset( $userid ) )
	{
		header( "Location: login.php" );
	}
?>