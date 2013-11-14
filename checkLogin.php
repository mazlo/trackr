<?php

	// read passed values
	$usr = $_GET["usr"];
	$pwd = $_GET["pwd"];

	if ( empty($usr) || empty($pwd) ) 
	{
		echo "<div>username or password parameter not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// insert new entry
    $result = $mysqli->query( "SELECT * FROM user WHERE username = '". $usr ."' AND password = '". $pwd ."'" );

    $row = $result->fetch_assoc();

    if ( $result && $row )
    	echo "true";
    else 
    	echo "false";

    $result->close();
	$mysqli->close();
?>