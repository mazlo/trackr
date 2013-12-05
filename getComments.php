
<?php
	// read passed values
	$entryId = $_REQUEST["eid"];

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
			<span style="display: table-cell;" class="searchable"><? echo $comments['comment']; ?></span>
			<span class="comment_delete_confirmation" eid='<? echo $entryId; ?>' cid='<? echo $comments['id']; ?>'>
				<button class='operatorButton confirmationButton'>sure?</button>
			</span>
		</li>
<? 	} 

	$result->close();
	$mysqli->close(); ?>