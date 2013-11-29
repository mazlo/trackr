<?php

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$whereClauseWithTags = '';
	$tags = '';

	// check if tag was given
	if ( !empty( $_GET['ts'] ) )
	{
		// compose where clause to query tags
		$tags = $_GET['ts'];

		$whereClauseWithTags = ' WHERE ( ';
		for ( $i=0; $i<count( $tags ); $i++ )
		{
			if ( $i != 0 )
				$whereClauseWithTags .= " AND ";

			$whereClauseWithTags .= "tags LIKE '%$tags[$i]%'";
		}
		$whereClauseWithTags .= ' )';
	}

	$query = 'SELECT id, title, description, listTitle, tags FROM entry'. $whereClauseWithTags .' ORDER BY id DESC';

    $result = $mysqli->query( $query );

	while( $row = $result->fetch_assoc() ) { ?>

	<!-- wrapper for one entry -->
	<div class="wrapper_entry filterableByTag" tags="<? echo $row['tags']; ?>">

		<a href='#' class='entry_delete_link' >-</a>
		<span class="entry_delete_confirmation" eid='<? echo $row['id']; ?>'><a href='#'>Sure?</a></span>

		<div class='entry'>
			
			<div style="float: left;">
				<span style='font-weight: bold'>#<? echo $row['id']; ?></span>
				<input class="textfield entry_title_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />
			</div>

			<div style="float: right; padding: 4px 12px 0 0">
				<input type="checkbox" />
			</div>

			<h4 class='entry_description searchable' style="clear: both"><? echo $row['description']; ?></h4>
			
			<a href="#" class="comment_add_link" eid="<? echo $row['id']; ?>">+</a>

			<?
			$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY position ASC' );

			if ( $result2 ) { ?>

				<!-- wrapper for comment dialog -->
				<div class='wrapper_comments'>
					<input class="textfield comments_title_inactive" eid='<? echo $row['id']; ?>' value="<?php echo $row['listTitle']; ?>" disabled="disabled" />

					<!-- div comment add: is hidden first -->
					<div id="comment_add_link_<? echo $row['id']; ?>" style="display: none;">
						<textarea id="comment_new_content_<? echo $row['id']; ?>" class="textarea_comment"></textarea>

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
							<span style="display: table-cell;"><a href='#' class='comment_delete_link' cid='<? echo $comments['id']; ?>'>-</a></span>
							<span style="display: table-cell;" class="searchable"><? echo $comments['comment']; ?></span>
							<span id="comment_delete_confirmation<? echo $comments['id']; ?>" class="comment_delete_confirmation" eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>'><a href='#'>Sure?</a></span>
						</li>
			 <?	} ?>
					</ul> 

			 <? $result2->close(); ?>
				</div>

				<div style="float: left">
					<span style="color: #aaa;">Tags:</span> 
					<input type="type" class="textfield tags_textfield_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['tags']; ?>" disabled="disabled" /> 
				</div>

				<div style="float: right; text-align: right">
					<a href="entry.php?eid=<? echo $row['id']; ?>">
						<button class="entry_details_link">Details</button>
					</a>
				</div>

				<div style="clear: both;"></div>

			</div>
		<? 	} ?>
		</div>
	</div>
	<?php
	}
	
	$result->close();
	$mysqli->close();

	?>