<?php

	// read passed values
	$entryId = $_GET["entry_id"];
	$comment = $_GET["comment"];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// get next id
	$next_id = 1;
	
	if ( $result = $mysqli->query( "SELECT MAX(id) as m FROM comment" ) ) 
	{
		$row = $result->fetch_assoc();
		$next_id = $row['m'] + 1;

		$result->free();
	}

	// insert new entry
    $mysqli->query( "INSERT INTO comment (id,comment,entry_id) VALUES (".$next_id.", '".$comment."', '".$entryId."')" );

    $result->close();

	// list all existing entries
	if ( $result = $mysqli->query( 'SELECT * FROM comment WHERE entry_id =  '. $entryId .' ORDER BY id DESC' ) )
	{
		while( $comments = $result->fetch_assoc() ) { ?>		
			<div class='comment' style='padding: 13px;'>
				<? echo $comments['comment']; ?>
			</div>
	<? 	}

		$result->free();
	}

	$mysqli->close();
?>