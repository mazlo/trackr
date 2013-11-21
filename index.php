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

</head>
	<body style="margin: auto">
		<div id="header" style="width: 80%; margin: auto; padding: 23px 0;">
			<div style="float: left;">
				<h2>Trackr</h2>
			</div>

			<div style="float: right; text-align: right">
				<span><? echo $_SESSION[ 'username' ] ?></span><a href="logout.php" style="margin-left: 23px; font-size: 13px; color: lightgray">logout</a>
			</div>
			
			<div style="clear: both;">
				<input type="text" id="search" class="textfield" style="width: 400px" />
				<span id="searchResults" style="margin-left: 13px; color: lightgray">&nbsp;</span>
			</div>
		</div>

		<div id="content" style="width: 80%; margin: auto">
			
			<div style="text-align: right">
				<a href="#">
					<button class="entry_add_link">+</button>
				</a>
			</div>

			<!-- div entry add: is hidden after page load -->
			<div id="div_entry_add" class="div_entry_add" style="display: none; margin: 8px 0;">

				<h4 class="entry_new_title">Title</h4>
				<input type="text" id="title" value="qwertqasd" class="textfield" />
				
				<h4 class="entry_new_description">Description</h4>
				<textarea id="description" class="textarea">aflijqwea</textarea>

				<div style="padding: 8px 0;">
					<input type="button" class="entry_add_button" value="Add" />
					<input type="button" class="entry_add_cancel" value="Cancel" />
				</div>

			</div>

			<!-- list of entries -->
			<div id="entries" style="margin-top: 8px;">
				<!-- ajax response here -->
			</div>
		</div>

		<div id="footer">
			&nbsp;
		</div>
	</body>

	<script type="text/javascript">

		// on document ready load all entries
		$jQ( function()
		{
			getAllEntries();
			$jQ( '#search' ).focus();
		});

		var getAllEntries = function()
		{
			$jQ.ajax( {
				url: "getAllEntries.php",
				type: "get",

				success: function( data ) 
				{
					$jQ( '#entries' ).html( data );
					$jQ( ".comments" ).sortable( {
						update: function( event, ui ) 
						{
							return updateCommentPositions( this );
						}
					});
					$jQ( ".comments" ).disableSelection();
				}
			});
		};

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

		// shows the div to add a new entry
		$jQ( document ).on( 'click', '.entry_add_link', function() 
		{
			$jQ( '#div_entry_add' ).effect( 'fade', 200, function() 
			{
				$jQ( '#div_entry_add' ).show();
				$jQ( '#title' ).focus();
			} );

			return true;
		});

		// hides the div to add a new entry
		$jQ( document ).on( 'click', '.entry_add_cancel', function()
		{
			$jQ( '#div_entry_add' ).effect( 'fade', 100, function()
			{
				$jQ( '#div_entry_add' ).hide();
			});

			return false;
		});

		// css manipulations on hover
		$jQ( document ).on( 'hover', '.entry_add_link, .entry_delete_link, .comment_add_link, .comment_delete_link', function()
		{
			$jQ(this).toggleClass('hover');
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

		// handler for clicking the add entry button
		$jQ( document ).on( 'click', '.entry_add_button', function() 
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
					$jQ( "#div_entry_add" ).hide();
					getAllEntries();
				}
			});

			return false;
		});

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

			$jQ(this).closest( '.wrapper_entry' ).effect( 'fade', 300, function()
				{
					$jQ.ajax( {
						url: "deleteEntry.php",
						type: "get",
						context: document.body,
						data: { entry_id: elementId },

						success: function( data ) 
						{
							getAllEntries();
						}
					});
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
		$jQ( document ).on('keypress', '.entry_title_inactive', function( event )
		{
			// on press of enter
			if ( event.which == 13 )
				$jQ(this).blur();
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

		// handling keyup event on search textfield
		$jQ( document ).on( 'keyup', '#search', function( event )
		{
			// escape key pressed
			if ( event.which == 27 )
			{
				// reset field values
				$jQ( this ).val( '' );
				$jQ( '.searchable' ).each( function()
				{
					$jQ( this ).css( 'background', 'transparent' );
				})
				$jQ( '#searchResults' ).text( '' );
				$jQ( this ).blur();

				return;
			}

			var counter = 0;
			var value = this.value.toLowerCase();
					
			$jQ( '.searchable' ).each( function() 
			{
				// reset all search fields first
				$jQ( this ).css( 'background', 'transparent' );
						
				// check if input is valid
				if ( value.length <= 2 )
				{
					$jQ( this ).css( 'background', 'transparent' );
					return;
				}
				
				// check if there are some results
				var found = $jQ( this ).text().toLowerCase().search( value );
				if ( found == -1 )
					return;
					
				// highligh those results
				$jQ( this ).css( 'background', '#c3d69b' );  
				counter += 1;
			} );
					
			// print number of results
			if ( counter != 0 )
				$jQ( "#searchResults").html( counter +' matches' );
			else
				$jQ( "#searchResults").html( '&nbsp' );
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

		// handling keypress event on comment title textfield
		$jQ( document ).on( 'keypress', '.comments_title_inactive', function( event )
		{
			// on press of enter
			if ( event.which == 13 )
				$jQ(this).blur();
		});

	</script>

</html>
