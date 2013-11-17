<?php

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	// get all entries
    $result = $mysqli->query( 'SELECT id,title,description FROM entry ORDER BY id DESC' );

	while( $row = $result->fetch_assoc() ) { ?>

	<!-- wrapper for one entry -->
	<div class="wrapper_entry">

		<a href='#' class='entry_delete_link' eid='<? echo $row['id']; ?>' style='display: block; padding: 3px 13px'>-</a>

		<div class='entry'>
			<span style='font-weight: bold'>#<? echo $row['id']; ?></span>
			<input class="textfield entry_title_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />


			<h4 class='entry_description'><? echo $row['description']; ?></h4>
			
			<a href="#" class="div_comment_add" eid="<? echo $row['id']; ?>">+</a>

			<?
			$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY position ASC' );

			if ( $result2 ) { ?>

				<!-- wrapper for comment dialog -->
				<div class='wrapper_comments'>
					<h4 class='comments_title'>Comments</h4>

					<!-- div comment add: is hidden first -->
					<div id="div_comment_add_<? echo $row['id']; ?>" style="display: none;">
						<textarea id="comment_new_content_<? echo $row['id']; ?>"></textarea>

						<div style="margin: 8px; 0">
							<input type="button" class="comment_add_button" eid="<? echo $row['id']; ?>" value="Add" />
							<input type="button" class="comment_add_cancel" eid="<? echo $row['id']; ?>" value="Cancel" />
						</div>
					</div>
					
					<!--  wrapper for all comments of an entry -->
					<ul id="comments_<? echo $row['id']; ?>" class="comments">
				<?
				while( $comments = $result2->fetch_assoc() ) { ?>		
						<li class='comment' cid='<? echo $comments['id']; ?>'>
							<span style="display: table-cell;"><a href='#' eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>' class='comment_delete_link'>-</a></span>
							<span style="display: table-cell;"><? echo $comments['comment']; ?></span>
						</li>
			<? 	} 

				$result2->close(); ?>
					</div>
				</div>
		<? 	} ?>
		</div>
	</div>
	<?php
	}
	
	$result->close();
	$mysqli->close();

	?>