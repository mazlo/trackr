
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

</head>

<?php
	$link = mysql_connect('localhost', 'root', 'root');

	if ( !$link ) 
	{
    	die( 'Verbindung nicht möglich : ' . mysql_error() );
	}
	
	$db_selected = mysql_select_db( 'shorter', $link );
	if ( !$db_selected ) 
	{
    	die ( 'Kann foo nicht benutzen : ' . mysql_error() );
	}

	$result = mysql_query( 'SELECT id,title,description FROM entry ORDER BY id DESC' );

	if ( !$result ) 
	{
    	die( 'Ungültige Anfrage: ' . mysql_error() );
	}
?>

	<body>
		<div id="header" style="height: 70px;">
			&nbsp;
		</div>
		
		<div id="content" style="width: 800; margin: auto">
			<h2>Hot This Week</h2>
			
			<a href="#" class="div_entry_add">+</a>

			<!-- div entry add: is hidden after page load -->
			<div id="div_entry_add" class="div_entry_add" style="display: none; padding: 13px;">

				<h4 class="entry_title">Title</h4>
				<input type="text" name="title" id="title" value="qwertqasd" />
				
				<h4 class="entry_description">Description</h4>
				<textarea rows="4" cols="25" name="description" id="description">aflijqwea</textarea>

				<div style="margin: 8px; 0">
					<input type="button" class="entry_add_button" value="Add" />
					<input type="button" class="entry_add_cancel" value="Cancel" />
				</div>

			</div>

			<!-- list of entries -->
			<div id="entries">
				<?php

				while( $row = mysql_fetch_array( $result ) ) { ?>

				<!-- wrapper for one entry -->
				<div class="wrapper_entry">

					<a href='#' class='entry_delete_link' eid='<? echo $row['id']; ?>' style='display: block; padding: 3px 13px'>-</a>

					<div class='entry'>
						<h4 class='entry_title'>#<? echo $row['id'] . " " . $row['title']; ?></h4>
						<h4 class='entry_description'><? echo $row['description']; ?></h4>
						
						<a href="#" class="div_comment_add" eid="<? echo $row['id']; ?>">+</a>

						<?
						$result2 = mysql_query( 'SELECT comment, date FROM comment WHERE entry_id = '. $row['id'] .' ORDER BY id DESC' );

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
						while( $comments = mysql_fetch_array( $result2 ) ) { ?>		
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
				
				mysql_close( $link );
			?>
			</div>
		</div>

		<div id="footer">
			&nbsp;
		</div>
	</body>

	<script type="text/javascript">

		// shows the div to add a new entry
		$jQ(".div_entry_add").click( function() 
		{
			$jQ( '#div_entry_add' ).effect( 'fade', 200, function() 
				{
					$jQ( '#div_entry_add' ).show();
				} );

			return true;
		});

		// hides the div to add a new entry
		$jQ( '.entry_add_cancel' ).click( function()
		{
			$jQ( '#div_entry_add' ).effect( 'fade', 100, function()
				{
					$jQ( '#div_entry_add' ).hide();
				} );

			return false;
		});

		$jQ( '.div_entry_add, .entry_delete_link, .div_comment_add' ).live( 'hover', function()
		{
			$jQ(this).toggleClass('hover');
		});

		// shows the div to add a new comment
		$jQ( '.div_comment_add' ).live( 'click', function()
		{
			var entryId = $jQ(this).attr('eid');

			$jQ( '#div_comment_add_'+ entryId ).effect( 'fade', 200, function()
				{
					$jQ( '#div_comment_add_'+ entryId ).show();
				});

			return true;
		});

		// hides the div to add a new comment
		$jQ( '.comment_add_cancel' ).click( function() 
		{
			var entryId = $jQ(this).attr('eid');
			$jQ( '#div_comment_add_'+ entryId ).hide();
		});

		// handler for clicking the add comment button
		$jQ( '.comment_add_button' ).click( function()
		{
			var entryId = $jQ(this).attr('eid');

			if ( $jQ( '#comment_new_content_'+ entryId ).val() == "" )
				return false;

			var comment = $jQ( '#comment_new_content_'+ entryId ).val();

			$jQ.ajax( {
				url: "addComment.php",
				type: "get",
				data: { entry_id: entryId, comment: comment },

				success: function( data ) 
				{
					$jQ( '#comments_'+ entryId ).html( data );
					$jQ( '#div_comment_add_'+ entryId ).hide();
				}
			});

		});

		$jQ( ".entry_add_button" ).click( function() 
		{
			var title = $jQ( '#title' ).val();
			if ( title == "" )
				return false;

			var description = $jQ( '#description' ).val();
			if ( description  == "" )
				return false;

			$jQ.ajax( {
				url: "addEntry.php",
				type: "get",
				data: { title: title, description: description },

				success: function( data ) 
				{
					$jQ( "#entries" ).html( data );
					$jQ( "#div_entry_add" ).hide();
				}
			});

			return false;
		});

		$jQ( '.entry_delete_link' ).live( 'click', function() 
		{
			var elementId = $jQ(this).attr( 'eid' );

			$jQ(this).closest( '.wrapper_entry' ).effect( 'fade', 300, function()
				{
					$jQ.ajax( {
						url: "deleteEntry.php",
						type: "get",
						context: document.body,
						data: { entry_id: elementId },

						success: function( data ) 
						{
							$jQ( "#entries" ).html( data );
						}
					});
				});
		});

	</script>

</html>
