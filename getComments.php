
<?php
	// read passed values
	$entryId = $_GET["eid"];

	if ( empty( $entryId) ) {
		echo "<div>eid not provided</div>";
		exit;
	}

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$result = $mysqli->query( 'SELECT comment, date FROM comment WHERE entry_id = '. $entryId .' ORDER BY id DESC' );

	if ( !$result ) {
		echo "<div>Could not get all comments</div>";  
		exit;
	} 

	while( $comments = $result->fetch_assoc() ) { ?>		
		<p class='comment' style='margin: 0; padding: 6px 13px;'>
			<? echo $comments['comment']; ?>
		</p>
<? 	} 

	$result->close(); ?>