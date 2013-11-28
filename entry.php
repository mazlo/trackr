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
	<script src="resources/missy.js"></script>

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
		<div id="header">

			<div style="width: 1000px; margin: auto;">
				<div style="float: left;">
					<h2 style="margin: 0"><span style="font-size: 36px">M</span>ind<span style="font-size: 36px">S</span>tash</h2>
				</div>

				<div style="float: right; text-align: right">
					<span id="searchResults" class="infotext">&nbsp;</span>
					<input type="text" id="search" class="textfield_smaller" style="width: 200px; margin-top: 6px; margin-right: 23px;" />
					<span><? echo $_SESSION[ 'username' ] ?></span><a href="logout.php" style="margin-left: 23px; color: lightgray">logout</a>
				</div>

				<div style="clear: both; height: 0"></div>
			</div>

		</div>

		<div id="content">

			<div style="position: absolute; top: 112px; margin-left: -103px; text-align: right">
				<a href="index.php">
					<img src="resources/back_arrow.png" alt="back" style="width: 63px;" />
				</a>
			</div>

			<div style="clear: both; height: 32px;">
				<h3>Showing You Details for Stash</h3>
			</div>

			<?php
				
			// get all entries
		    $result = $mysqli->query( 'SELECT title, description, listTitle, tags FROM entry WHERE id = '. $entry_id .'' );
			$row = $result->fetch_assoc(); ?>

			<span class="entry_delete_confirmation" eid='<? echo $entry_id; ?>'><a href='#'>Sure?</a></span>

			<div class='entry_details'>
				<span style='font-weight: bold'>#<? echo $entry_id; ?></span>
				<input class="textfield entry_title_inactive" eid='<? echo $entry_id; ?>' value="<? echo $row['title']; ?>" disabled="disabled" />

				<h4 class='entry_description searchable'><? echo $row['description']; ?></h4>
				
				<div style="float: left; margin-top: 23px; text-align: right">
					<button class="entry_delete_link button">delete</button>
					<span class="entry_delete_confirmation" eid='<? echo $entry_id; ?>'><a href='#'>Sure?</a></span>
				</div>

				<div style="float: right; margin-top: 23px; text-align: right">
					<button class="comment_add_link button" eid="<? echo $entry_id; ?>">+</button>
				</div>

				<?
				$result2 = $mysqli->query( 'SELECT id, comment, date FROM comment WHERE entry_id = '. $entry_id .' ORDER BY position ASC' );

				if ( $result2 ) { ?>

				<!-- wrapper for comment dialog -->
				<div class='wrapper_comments' style="clear: both; margin-top: 64px; ">
					<input class="textfield comments_title_inactive" eid='<? echo $entry_id; ?>' value="<?php echo $row['listTitle']; ?>" disabled="disabled" />

					<!-- div comment add: is hidden first -->
					<div id="comment_add_link_<? echo $entry_id; ?>" style="display: none;">
						<textarea id="comment_new_content_<? echo $entry_id; ?>" class="textarea_comment"></textarea>

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
							<span id="comment_delete_confirmation<? echo $comments['id']; ?>" class="comment_delete_confirmation" eid='<? echo $entry_id; ?>' cid='<? echo $comments['id']; ?>'><a href='#'>Sure?</a></span>
						</li>
			 	<?} ?>
					</ul> 
				</div>

				<div>
					<span style="color: #aaa;">Tags:</span> 
					<input type="type" class="textfield tags_textfield_inactive" eid='<? echo $entry_id; ?>' value="<? echo $row['tags']; ?>" disabled="disabled" /> 
				</div>
				<?}

				$result->close();
			 	$mysqli->close(); ?>
			</div>

		</div>

		<div id="footer">
			&nbsp;
		</div>
	</body>

	<script type="text/javascript">

		$jQ( ".comments" ).sortable( {
			update: function( event, ui ) 
			{
				return updateCommentPositions( this );
			}
		});
		$jQ( ".comments" ).disableSelection();

		// handler for clicking the delete entry button
		$jQ( document ).on( 'click', '.entry_delete_link', function(e) { return deleteEntryConfirm( e, this ); } );

		// handler for clicking the confirmation dialog for delete entry button
		$jQ( document ).on( 'click', '.entry_delete_confirmation', function() 
		{ 
			return deleteEntry( this, '.entry_details', function()
			{
				document.location = "index.php";
			} ); 
		} );

		// shows the div to add a new comment
		$jQ( document ).on( 'click', '.comment_add_link', function() { return showAddCommentDiv( this ); } );

		// hides the div to add a new comment
		$jQ( document ).on( 'click', '.comment_add_cancel', function() { return hideAddCommentDiv( this ); } );

		// handler for clicking the add comment button
		$jQ( document ).on( 'click', '.comment_add_button', function() { return addCommentAction( this ); } );

		// handler for clicking the delete comment button
		$jQ( document ).on( 'click', '.comment_delete_link', function(e) { return deleteCommentConfirm( e, this ); } );

		// handler for clicking the confirmation dialog for delete comment button
		$jQ( document ).on( 'click', '.comment_delete_confirmation', function() { return deleteComment( this ); } );

		// handler to change title of entry
		$jQ( document ).on( 'blur', '.entry_title_inactive', function(e) 
		{
			var title = $jQ(this).val();

			if ( oldTitle == title )
				return;

			var entryId = $jQ(this).attr( 'eid' );

			$jQ(this).after( "<span id='entry_title_confirm_"+ entryId +"' class='entry_title_confirm'></span>" );

			// ajax call to change title
			$jQ.ajax( {
				url: "changeEntryTitle.php",
				type: "get",
				data: { eid: entryId, tl: title },

				success: function( data ) 
				{
					var dialog = $jQ( '#entry_title_confirm_'+ entryId )
					dialog.html( 'done' );
					dialog.css( 'top', e.target.offsetTop + 1 );
					dialog.css( 'left', 100 );
					dialog.effect( 'fade', 2000, function() 
					{
						$jQ(this).remove();
					} );
				}
			});
		});

		// handler to change comment title of entry
		$jQ( document ).on( 'blur', '.comments_title_inactive', function(e) 
		{
			var title = $jQ(this).val();

			if ( commentsOldTitle == title )
				return;

			var entryId = $jQ(this).attr( 'eid' );

			$jQ(this).after( "<span id='comments_title_confirm_"+ entryId +"' class='comments_title_confirm'></span>" );

			// ajax call to change title
			$jQ.ajax( {
				url: "changeListTitle.php",
				type: "get",
				data: { eid: entryId, tl: title },

				success: function( data ) 
				{
					var dialog = $jQ( '#comments_title_confirm_'+ entryId )
					dialog.html( 'done' );
					dialog.css( 'top', e.target.offsetTop + 1 );
					dialog.css( 'left', 100 );
					dialog.effect( 'fade', 2000, function() 
					{
						$jQ(this).remove();
					} );
				}
			});
		});

		// handling keypress event on title textfield
		$jQ( document ).on('keypress', '.entry_title_inactive', function(e) { return confirmChangeWithEnter( e, this ); } );

		// handling keypress event on title textfield
		$jQ( document ).on('keypress', '.comments_title_inactive', function(e) { return confirmChangeWithEnter( e, this ); } );


		// css manipulations on hover
		$jQ( document ).on( 'hover', '.entry_title_inactive', function() { return toggleDisabledElement( this, 'entry_title' ); } );

		$jQ( document ).on( 'hover', '.comments_title_inactive', function() { return toggleDisabledElement( this, 'entry_title' ); } );

		$jQ( document ).on( 'click', '.entry_title_inactive', function() { oldTitle = $jQ(this).val(); });

		$jQ( document ).on( 'hover', '.comment_delete_link', function()	{ $jQ(this).toggleClass('hover'); } );

		// handler to change title of list
		$jQ( document ).on( 'click', '.comments_title_inactive', function() 
		{
			commentsOldTitle = $jQ(this).val();
		});

		// handling keypress event on new entry title
		$jQ( document ).on( 'keyup', '#title', function( event )
		{
			// on press of enter
			if ( event.which == 13 )
				$jQ( '#description' ).focus();
			else if ( event.which == 27 )
				$jQ( '.entry_add_cancel' ).click();
		});

		// handling keypress event on new entry description
		$jQ( document ).on( 'keyup', '#description', function( event )
		{
			// on press of enter
			if ( event.which == 13 )
				$jQ( '.entry_add_button' ).click();
			else if ( event.which == 27 )
				$jQ( '.entry_add_cancel' ).click();
		});


	</script>

</html>