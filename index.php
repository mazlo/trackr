
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
		});

		var getAllEntries = function()
		{
			$jQ.ajax( {
				url: "getAllEntries.php",
				type: "get",

				success: function( data ) 
				{
					$jQ( '#entries' ).html( data );
				}
			});
		};

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
