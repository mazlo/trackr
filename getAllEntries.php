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

	$query = 'SELECT id, title, description, listTitle, tags, favored FROM entry'. $whereClauseWithTags .' ORDER BY favored DESC, id DESC';

    $result = $mysqli->query( $query );

	while( $row = $result->fetch_assoc() ) { ?>

	<!-- wrapper for one entry -->
	<div class="wrapper_entry filterableByTag" tags="<? echo $row['tags']; ?>">

		<div class='entry'>
			
			<div class='entryIcon'>
				<span style='font-weight: bold'>#<? echo $row['id']; ?></span>
			</div>

			<div class='entryDetails'>
				<input class="textfield entry_title_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />
				<span class='entry_title_confirm'>
					<button class='operatorButton doneButton'>Done</button>
				</span>
				<h4 class='entry_description searchable'><? echo $row['description']; ?></h4>
			</div>

			<div class='entryOperations'>
				<button class="comment_add_link operatorButton" eid="<? echo $row['id']; ?>">add <span id="comment_add_button_text_<? echo $row['id']; ?>"><? echo $row['listTitle'];?></span></button>
				<button class="entry_delete_link operatorButton" eid="<? echo $row['id']; ?>">delete Stackr</button>
				<span class="entry_delete_confirmation" eid='<? echo $row['id']; ?>'>
					<button class='operatorButton confirmationButton'>Sure?</button>
				</span>
			</div>

			<div class='entryButtons'>
				<img src="resources/pinIt_<? echo $row['favored']; ?>.png" class="favoredIcon" alt="<? echo $row['favored']; ?>" width="28px" eid="<? echo $row['id']; ?>" />
			</div>

			<div style="clear: both; height: 0px"></div>

			<?
			$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY position ASC' );

			if ( $result2 ) { ?>

				<!-- wrapper for all comments -->
				<div class='wrapper_comments'>
					<input class="textfield comments_title_inactive" eid='<? echo $row['id']; ?>' value="<?php echo $row['listTitle']; ?>" disabled="disabled" />
					<span class='comments_title_confirm'>
						<button class='operatorButton doneButton'>Done</button>
					</span>
						
					<div class='comment_add_div' id="comment_add_link_<? echo $row['id']; ?>" style="display: none;">
						<!-- div comment add: is hidden first -->
						<textarea id="comment_new_content_<? echo $row['id']; ?>" class="textarea_comment"></textarea>

						<div style="padding: 8px 0;">
							<button class="comment_add_button operatorButton" eid="<? echo $row['id']; ?>">add</button>
							<button class="comment_add_cancel operatorButton" eid="<? echo $row['id']; ?>">cancel</button>
						</div>
					</div>
					
					<ul id="comments_<? echo $row['id']; ?>" class="comments">
				<?
				while( $comments = $result2->fetch_assoc() ) { ?>		
						<li class='comment' cid='<? echo $comments['id']; ?>'>
							<span style="display: table-cell;"><a href='#' class='comment_delete_link' cid='<? echo $comments['id']; ?>'>-</a></span>
							<span style="display: table-cell;" class="searchable"><? echo $comments['comment']; ?></span>
							<span class="comment_delete_confirmation" eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>'>
								<button class='operatorButton confirmationButton'>sure?</button>
							</span>
						</li>
			 <?	} ?>
					</ul> 

			 <? $result2->close(); ?>
				</div>

				<div class='entryFooter'>

					<div style="float: left">
						<span style="color: #aaa;">Tags:</span> 
						<input type="type" class="textfield tags_textfield_inactive" eid='<? echo $row['id']; ?>' value="<? echo $row['tags']; ?>" disabled="disabled" /> 
					</div>

					<div style="float: right; text-align: right">
						<a href="entry.php?eid=<? echo $row['id']; ?>">
							<button class="entry_details_link operatorButton">details</button>
						</a>
					</div>

					<div style="clear: both;"></div>
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