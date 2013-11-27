<?php

	session_start();

	if ( empty( $_SESSION[ 'username' ] ) )
	{
		header( "Location: login.php" );
	}

	$username = $_SESSION[ 'username' ];
	$auth_string = crypt( $username, '$1tu8CWdqTf9.' );

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// query database for auth_string
	$result = $mysqli->query( "SELECT id FROM user WHERE auth_string = '$auth_string'" );
	$row = $result->fetch_assoc();

	// redirect to login page if user could not be authenticated
	if( !isset( $row['id'] ) )
	{
		header( "Location: login.php" );
	}
?>