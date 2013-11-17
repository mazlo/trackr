
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

	$result = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $entryId .' ORDER BY position ASC' );

	if ( !$result ) {
		echo "<div>Could not get all comments</div>";  
		exit;
	} 

	while( $comments = $result->fetch_assoc() ) { ?>		
		<li class='comment' cid='<? echo $comments['id']; ?>'>
			<span style="display: table-cell;"><a href='#' class='comment_delete_link' cid='<? echo $comments['id']; ?>'>-</a></span>
			<span style="display: table-cell;"><? echo $comments['comment']; ?></span>
			<span id="comment_delete_confirmation<? echo $comments['id']; ?>" class="comment_delete_confirmation" eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>'><a href='#'>Sure?</a></span>
		</li>
<? 	} 

	$result->close(); ?>