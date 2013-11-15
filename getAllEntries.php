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
			<input class="h4_entry_title_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />
			<span id="entry_title_confirm_<? echo $row['id']; ?>" style="color: green"></span>

			<h4 class='entry_description'><? echo $row['description']; ?></h4>
			
			<a href="#" class="div_comment_add" eid="<? echo $row['id']; ?>">+</a>

			<?
			$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY id DESC' );

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
					<ul id="comments_<? echo $row['id']; ?>" class="comments">
				<?
				while( $comments = $result2->fetch_assoc() ) { ?>		
						<li class='comment' id='comment_<? echo $comments['id']; ?>' style='margin: 0; padding: 6px 0px;'>
							<a href='#' eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>' class='comment_delete_link' style='padding: 3px 13px; '>-</a> <? echo $comments['comment']; ?>
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