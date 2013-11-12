
<?php

	// read passed values
	$entry_id = $_GET["entry_id"];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// delete
	$mysqli->query( 'DELETE FROM entry WHERE id = '. $entry_id );
	
	// list all existing entries
	if ( $result = $mysqli->query( 'SELECT * FROM entry ORDER BY id DESC' ) )
	{
		while( $row = $result->fetch_assoc() ) { ?>

		<!-- wrapper for one entry -->
		<div class="wrapper_entry">

			<a href='#' class='entry_delete_link' eid='<? echo $row['id']; ?>' style='display: block; padding: 3px 13px'>-</a>

			<div class='entry'>
				<h4 class='entry_title'>#<? echo $row['id'] . " " . $row['title']; ?></h4>
				<h4 class='entry_description'><? echo $row['description']; ?></h4>
				
				<a href="#" class="div_comment_add" eid="<? echo $row['id']; ?>">+</a>

				<?
				$result2 = $mysqli->query( 'SELECT comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY id DESC' );

				if ( $result2 ) { ?>

					<!-- wrapper for comment dialog -->
					<div class='wrapper_comments'>
						<h4 class='entry_title' style='margin: 6px 0;'>Comments</h4>

						<!-- div comment add: is hidden first -->
						<div id="div_comment_add_<? echo $row['id']; ?>" style="display: none;">
							<textarea id="comment_new_content_<? echo $row['id']; ?>"></textarea>
							
							<div style="margin: 8px; 0">
								<input type="button" class="comment_add_button" eid="<? echo $row['id']; ?>" value="Add" />
								<input type="button" class="comment_add_cancel" eid="<? echo $row['id']; ?>" value="Cancel" />
							</div>
						</div>
						
						<!--  wrapper for all comments of an entry -->
						<div id="comments_<? echo $row['id']; ?>">
					<?
					while( $comments = $result2->fetch_assoc() ) { ?>		
							<p class='comment' style='margin: 0; padding: 6px 13px;'>
								<? echo $comments['comment']; ?>
							</p>
				<? 	} ?>
						</div>
					</div>
			<? 	} ?>
			</div>
		</div>
	<?php
		}

		$result->free();
	}

	$mysqli->close();
?>