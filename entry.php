<?php
	include( 'authenticate.php' );
?>

<html>
<head>
	<!-- external -->
	<!-- simplifies javascript programming -->
	<link rel="stylesheet" type="text/css" href="resources/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="resources/main.css"></link>

	<script src="resources/prototype.js"></script>
	<script src="resources/jquery-1.8.2.js"></script>
	<script src="resources/jquery-ui-1.9.2.custom.js"></script>

	<script type="text/javascript">
		<!-- this is to prevent conflicts with prototype and jquerytools -->
		$jQ = jQuery.noConflict();
	</script>

	<?php

	$entry_id = $_GET['eid'];

	// connect
	$mysqli = new mysqli( "localhost", "root", "root", "shorter");

	if ( $mysqli->connect_errno ) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	?>

</head>
	<body style="margin: auto">
		<div id="header" style="width: 80%; margin: auto; padding: 23px 0;">
			<div style="float: left;">
				<h2>Trackr</h2>
			</div>

			<div style="float: right; text-align: right">
				<span><? echo $_SESSION[ 'username' ] ?></span><a href="logout.php" style="margin-left: 23px; font-size: 13px; color: lightgray">logout</a>
			</div>

			<div style="clear: both;">&nbsp;</div>
		</div>

		<div id="content" style="width: 80%; margin: auto">

			<?php
				
			// get all entries
		    $result = $mysqli->query( 'SELECT title, description, listTitle FROM entry WHERE id = '. $entry_id .'' );
			$row = $result->fetch_assoc(); ?>

			<!-- wrapper for one entry -->
			<div class="wrapper_entry">

				<a href='#' class='entry_delete_link' >-</a>
				<span class="entry_delete_confirmation" eid='<? echo $entry_id; ?>'><a href='#'>Sure?</a></span>

				<div class='entry'>
					<span style='font-weight: bold'>#<? echo $entry_id; ?>&nbsp;</span>
					<input class="textfield entry_title_inactive" eid='<? $entry_id; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />

					<h4 class='entry_description searchable'><? echo $row['description']; ?></h4>
					
					<a href="#" class="comment_add_link" eid="<? echo $entry_id; ?>">+</a>

					<?
					$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $entry_id .' ORDER BY position ASC' );

					if ( $result2 ) { ?>

					<!-- wrapper for comment dialog -->
					<div class='wrapper_comments'>
						<input class="textfield comments_title_inactive" eid='<? echo $entry_id; ?>' value="<?php echo $row['listTitle']; ?>" disabled="disabled" />

						<!-- div comment add: is hidden first -->
						<div id="comment_add_link_<? echo $entry_id; ?>" style="display: none;">
							<textarea id="comment_new_content_<? $entry_id; ?>" class="textarea_comment"></textarea>

							<div style="margin: 8px; 0">
								<input type="button" class="comment_add_button" eid="<? echo $entry_id; ?>" value="Add" />
								<input type="button" class="comment_add_cancel" eid="<? echo $entry_id; ?>" value="Cancel" />
							</div>
						</div>
						
						<!--  wrapper for all comments of an entry -->
						<ul id="comments_<? echo $entry_id; ?>" class="comments">
						<?
						while( $comments = $result2->fetch_assoc() ) { ?>		
							<li class='comment' cid='<? echo $comments['id']; ?>'>
								<span style="display: table-cell;"><a href='#' class='comment_delete_link' cid='<? echo $comments['id']; ?>'>-</a></span>
								<span style="display: table-cell;" class="searchable"><? echo $comments['comment']; ?></span>
								<span id="comment_delete_confirmation<? echo $comments['id']; ?>" class="comment_delete_confirmation" eid='<? echo $row['id']; ?>' cid='<? echo $comments['id']; ?>'><a href='#'>Sure?</a></span>
							</li>
				 	<?} ?>
						</ul> 

					<?}
					
					$result->close();
				 	$mysqli->close(); ?>
					</div>
				</div>
			</div>

		</div>

		<div id="footer">
			&nbsp;
		</div>
	</body>

</html>