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
			
			<div style="position: absolute; top: 42px; margin-left: -103px; text-align: right">
				<a href="index.php">
					<img src="resources/back_arrow.png" alt="back" style="width: 63px;" />
				</a>
			</div>

			<div style="float: left;">
				<h2>Trackr</h2>
			</div>

			<div style="float: right; text-align: right">
				<span><? echo $_SESSION[ 'username' ] ?></span><a href="logout.php" style="margin-left: 23px; font-size: 13px; color: lightgray">logout</a>
			</div>

			<div style="clear: both; height: 32px;">
				<h3>Showing You Details for Trackr</h3>
			</div>
		</div>

		<div id="content" style="width: 80%; margin: auto">

			<?php
				
			// get all entries
		    $result = $mysqli->query( 'SELECT title, description, listTitle FROM entry WHERE id = '. $entry_id .'' );
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
				<div class='wrapper_comments' style="clear: both; margin-top: 80px; ">
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

				<?}

				$result->close();
			 	$mysqli->close(); ?>
				</div>
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

		var getComments = function( eid )
		{
			$jQ.ajax( {
				url: "getComments.php",
				type: "get",
				data: { eid: eid }, 

				success: function( data ) 
				{
					$jQ( '#comments_'+ eid ).html( data );
				}
			});
		};

		var updateCommentPositions = function( object )
		{
			var counter = 0;
			var cid = [];
			var pos = [];

			$jQ(object).find( '.comment' ).each( function()
			{
				cid.push( $jQ(this).attr( 'cid' ) );
				pos.push( ++counter );
			});

			$jQ.ajax( {
				url: "changeCommentPosition.php",
				type: "get",
				data: { cid: cid, pos: pos }
			});
		};

		// handler for clicking the delete entry button
		$jQ( document ).on( 'click', '.entry_delete_link', function( e ) 
		{
			var x = 100;
			var y = e.target.offsetTop + 1;

			var dialog = $jQ(this).next( '.entry_delete_confirmation' );
			dialog.css( 'left', x );
			dialog.css( 'top', y );
			dialog.show();

			setTimeout( function() { $jQ( dialog ).effect( 'fade', 1000 ); }, 2000 );

			return false;
		});

		// handler for clicking the confirmation dialog for delete entry button
		$jQ( document ).on( 'click', '.entry_delete_confirmation', function()
		{
			$jQ(this).hide();

			var elementId = $jQ(this).attr( 'eid' );

			$jQ(this).closest( '.entry_details' ).effect( 'fade', 300, function()
				{
					$jQ.ajax( {
						url: "deleteEntry.php",
						type: "get",
						context: document.body,
						data: { entry_id: elementId },

						success: function( data ) 
						{
							document.location = "index.php";
						}
					});
				});

			return false;
		});

		// shows the div to add a new comment
		$jQ( document ).on( 'click', '.comment_add_link', function()
		{
			var entryId = $jQ(this).attr('eid');

			$jQ( '#comment_add_link_'+ entryId ).effect( 'fade', 200, function()
				{
					$jQ( '#comment_add_link_'+ entryId ).show();
				});

			return false;
		});

		// hides the div to add a new comment
		$jQ( document ).on( 'click', '.comment_add_cancel', function() 
		{
			var entryId = $jQ(this).attr('eid');
			$jQ( '#comment_add_link_'+ entryId ).effect( 'fade', 100, function()
				{
					$jQ( '#comment_add_link_'+ entryId ).hide();
				} );

			return false;
		});

		// handler for clicking the add comment button
		$jQ( document ).on( 'click', '.comment_add_button', function()
		{
			var entryId = $jQ(this).attr('eid');

			if ( $jQ( '#comment_new_content_'+ entryId ).val() == "" )
				return;

			var comment = $jQ( '#comment_new_content_'+ entryId ).val();

			$jQ.ajax( {
				url: "addComment.php",
				type: "get",
				data: { eid: entryId, comment: comment },

				success: function( data ) 
				{
					$jQ( '#comment_add_link_'+ entryId ).hide();
					getComments( entryId );
				}
			});

			return false;
		});

		// handler for clicking the delete comment button
		$jQ( document ).on( 'click', '.comment_delete_link', function( e )
		{
			var x = 100;
			var y = e.target.offsetTop + 1;

			var cdialog = $jQ(this).parent().nextAll( '.comment_delete_confirmation' );
			cdialog.css( 'left', x );
			cdialog.css( 'top', y );
			cdialog.show();

			setTimeout( function() { $jQ( cdialog ).effect( 'fade', 1000 ); }, 2000 );

			return false;
		});

		// handler for clicking the confirmation dialog for delete comment button
		$jQ( document ).on( 'click', '.comment_delete_confirmation', function()
		{
			$jQ(this).hide();

			var entryId = $jQ(this).attr( 'eid' );
			var commentId = $jQ(this).attr( 'cid' );

			$jQ(this).closest( '.comment' ).effect( 'fade', 300, function()
				{
					$jQ.ajax( {
						url: "deleteComment.php",
						type: "get",
						context: document.body,
						data: { eid: entryId, cid: commentId },

						success: function( data ) 
						{
							getComments( entryId );
						}
					});
				});

			return false;
		});

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
		$jQ( document ).on('keypress', '.entry_title_inactive, .comments_title_inactive', function( event )
		{
			// on press of enter
			if ( event.which == 13 )
				$jQ(this).blur();
		});

		// css manipulations on hover
		$jQ( document ).on( 'hover', '.entry_title_inactive', function() 
		{
			$jQ(this).toggleClass( 'entry_title' );
			$jQ(this).removeAttr( 'disabled' );
		});

		$jQ( document ).on( 'hover', '.comments_title_inactive', function() 
		{
			$jQ(this).toggleClass( 'comments_title' );
			$jQ(this).removeAttr( 'disabled' );
		});

		$jQ( document ).on( 'click', '.entry_title_inactive', function() 
		{
			oldTitle = $jQ(this).val();
		});

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