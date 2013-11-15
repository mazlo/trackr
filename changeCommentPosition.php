<?php

	// read passed values
	$cids = $_GET["cid"];
	$poss = $_GET["pos"];

	if ( empty( $cids ) || empty( $poss ) )
	{
		echo "<div>cid or poss parameter not provided</div>";
		exit;
	}

	if ( sizeof( $cids ) != sizeof( $poss ) )
	{
		echo "<div>cid and pos not of the same size.</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// update comment positions
	for ( $i = 0; $i < sizeof($cids); $i++ )
	{
		$stmt = $mysqli->prepare( "UPDATE comment SET position = ? WHERE id = ?;" ); 
		$stmt->bind_param( 'ii', $poss[ $i ], $cids[ $i ] );
		$stmt->execute(); 
	}
	
	$stmt->close();
	$mysqli->close();

	echo "done";
?>