<html>
<head>
	<!-- external -->
	<!-- simplifies javascript programming -->
	<link rel='stylesheet' type='text/css' href='{{ url( "resources/jquery-ui.css" ) }}' />
	<link rel='stylesheet' type='text/css' href='{{ url( "resources/main.css" ) }}'></link>

	<script src='{{ url( "resources/prototype.js" ) }}'></script>
	<script src='{{ url( "resources/jquery-1.8.2.js" ) }}'></script>
	<script src='{{ url( "resources/jquery-ui-1.9.2.custom.js" ) }}'></script>
	<script src='{{ url( "resources/missy.js" ) }}'></script>

	<script type='text/javascript'>
		<!-- this is to prevent conflicts with prototype and jquerytools -->
		$jQ = jQuery.noConflict();
	</script>

</head>
	<body>
		<div id='container'>

			<!-- header contains logo and login -->
			<div id='header'>
				
				<div style='width: 30%'>
					<a href='{{ URL::to( "contexts" ) }}'>
						<img src='{{ url( "resources/stack.png" ) }}' style='width: 32px; margin-bottom: -4px;' />
						<h2 class='applicationTitle'><span style='font-size: 32px'>M</span>ind<span style='font-size: 32px'>S</span>tackr</h2>
					</a>
				</div>

				<div style='width: 70%; text-align: right'>
	 				@if ( Auth::check() )
	 					<!-- print search field -->
		 				<span id='searchResults' class='infotext'></span>
						<input type='text' id='search' class='textfield_smaller' style='width: 200px; margin-right: 26px;' />

						<!-- print user specific information -->
	 					<span>{{ Auth::user()->username }}</span>
						<a class='dotted' style='margin-left: 23px;' href='{{ URL::route( 'user/logout' ) }}'>
							sign out
						</a>
					@else
						<a class='dotted' href='{{ URL::route( 'users/register' ) }}'>Register</a>
					@endif
				</div>

			</div>

			<!-- navigation contains tag list -->
			<div id='beforeContent'>
				@yield( 'beforeContent' )
			</div>

			<!-- content contains list of entries -->
			<div id='content'>

				@yield( 'content' )

			</div>

			<div id='footer' style='margin-top: 48px'>
				
				@yield( 'footer' )

			</div>
		</div>
	</body>

<script type='text/javascript'>

	// on document ready load all entries
	$jQ( function()
	{
		@if( Auth::check() )
			@yield( 'onDocumentLoad' )
		@endif
	});

// GLOBAL EVENTS

	// css manipulations on hover
	$jQ( document ).on( 'hover', '.entry_add_link, .entry_delete_link, .comment_add_link, .comment_delete_link', function()
	{
		$jQ(this).toggleClass( 'hover' );
	});

	// handle scroll on window
	$jQ( window ).scroll( function() 
	{
		if ( window.pageYOffset > 20 )
			$jQ( '#header' ).css( 'box-shadow', '0px 2px 2px #eee' );
		else
			$jQ( '#header' ).css( 'box-shadow', 'none' );
	});

	// handle keyup on search textfield
	$jQ( document ).on( 'keyup', '#search', function( event )
	{
		// escape key pressed -> reset field values
		if ( event.which == 27 )
		{
			$jQ( this ).val( '' );
			$jQ( '.searchable' ).each( function()
			{
				$jQ( this ).css( 'background', 'transparent' );
			})
			$jQ( '#searchResults' ).text( '' );
			$jQ( this ).blur();

			return;
		}

		// for any other key

		var counter = 0;
		var value = this.value.toLowerCase();

		// iterate all searchable elements
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
			$jQ( "#searchResults").text( counter +' matches' );
		else
			$jQ( "#searchResults").html( '&nbsp;' );
	});

// EVENTS REGARDING ADDING OR DELETING A CONTEXT

	// shows the div to add a new entry
	$jQ( document ).on( 'click', '.context_add_link', function() { return showDiv( '#div_context_add' ); } );

	// hides the div to add a new entry
	$jQ( document ).on( 'click', '.context_add_cancel', function() { return hideDiv( '#div_context_add' ); } );

	// handle click on add entry button
	$jQ( document ).on( 'click', '.context_add_button', function() { return addContextAction(); } );

// EVENTS REGARDING ADDING OR DELETING AN ENTRY

	// shows the div to add a new entry
	$jQ( document ).on( 'click', '.entry_add_link', function() { return showDiv( '#div_entry_add' ); } );

	// hides the div to add a new entry
	$jQ( document ).on( 'click', '.entry_add_cancel', function() { return hideDiv( '#div_entry_add' ); } );

	// handle click on add entry button
	$jQ( document ).on( 'click', '.entry_add_button', function() { return addEntryAction(); } );

	// handle keypress on textfield entry title
	$jQ( document ).on( 'keyup', '#title', function( event ) 
	{ 
		var value = $jQ(this).val();

		confirmChange( event, 
		{
			onEnter : function() 
			{
				if ( value != '' )
					$jQ( '#description' ).focus();
			},
			onEscape : function()
			{
				$jQ( '.entry_add_cancel' ).click();
			}
		});

	} );

	// handle keypress on textfield entry description
	$jQ( document ).on( 'keyup', '#description', function( event )
	{
		confirmChange( event, 
		{
			onEnter : function() 
			{
				$jQ( '.entry_add_button' ).click();
			},
			onEscape : function()
			{
				$jQ( '.entry_add_cancel' ).click();
			}
		});

	});

	// handle click on delete entry button
	$jQ( document ).on( 'click', '.entry_delete_link', function(e) { return deleteEntryConfirm( e, this ); } );

	// handle click on confirmation dialog for delete entry button
	$jQ( document ).on( 'click', '.entry_delete_confirmation', function() 
	{ 
		return deleteEntry( this, '.wrapper_entry', function()
		{
			getAllEntries();
			getDistinctEntriesTagList();
		} ); 
	} );

// EVENTS REGARDING CHANGES TO ENTRY PROPERTIES

// TITLE
	// handle hover on textfield 'entry title'
	$jQ( document ).on( 'hover', '.entry_title_inactive', function() { return toggleDisabledElement( this, 'entry_title' ); } );

	// handle click on textfield 'entry title'
	$jQ( document ).on( 'click', '.entry_title_inactive', function() 
	{
		oldTitle = $jQ(this).val();
	});

	// handle keypress on textfield 'entry title'
	$jQ( document ).on( 'keypress', '.entry_title_inactive', function(e) { return confirmChangeWithEnter( e, this ); } );

	// handle blur on textfield 'entry title'
	$jQ( document ).on( 'blur', '.entry_title_inactive', function(e) { return updateEntryTitle( e, this ); } );

// TAG BUTTONS
	// handle click on tag button
	$jQ( document ).on( 'click', '.entry_tag', function()
	{
		var selectedTags = [];

		// collect all selected tag buttons
		$jQ( '.ui-state-active' ).each( function()
		{
			selectedTags.push( $jQ(this).text() );
		});

		// for each element that is filterable by tag
		$jQ( '.filterableByTag' ).each( function()
		{
			// show element first
			$jQ(this).show();

			// now decide if element should be disabled

			if ( selectedTags.size() == 0 )
				return;

			var elementTags = $jQ(this).attr( 'tags' );
			if ( elementTags.length == 0 )
				return;

			elementTags = elementTags.split(', ');

			var show = true;
			selectedTags.forEach( function(tag) 
			{
			    if ( elementTags.indexOf( tag ) != -1 && show )
		    		show = true;
			    else 
			    	show = false;
			});

			if ( !show )
				$jQ(this).hide();
		});

	} );

	// handle click on clear selection button
	$jQ( document ).on( 'click', '#clearTags', function()
	{
		$jQ( '.ui-state-active' ).each( function()
		{
			$jQ(this).toggleClass('ui-state-active');
		});

		$jQ( '.filterableByTag' ).each( function()
		{
			$jQ(this).show();
		});
	});

	// handle click on favored icon
	$jQ( document ).on( 'click', '.favoredIcon', function() { return updateEntryFavored( this ); } );

// TAGS TEXTFIELD
	// handle hover on textfield 'tags'
	$jQ( document ).on( 'hover', '.tags_textfield_inactive', function() { return toggleDisabledElement( this, 'tags_textfield' ); } );

	// handle keypress on textfield 'tags'
	$jQ( document ).on( 'keyup', '.tags_textfield_inactive', function(e) { return confirmChangeOfTags( e, this ); } );

	// handle blur on textfield 'tags'
	$jQ( document ).on( 'blur', '.tags_textfield_inactive', function() { return updateTags( this ); } );

// EVENTS REGARDING ADDING OR DELETING COMMENTS

	// show div to add a new comment
	$jQ( document ).on( 'click', '.comment_add_link', function() { return showAddCommentDiv( this ); } );

	// hide div to add a new comment
	$jQ( document ).on( 'click', '.comment_add_cancel', function() { return hideAddCommentDiv( this ); } );

	// handle click on comment add button
	$jQ( document ).on( 'click', '.comment_add_button', function() { return addCommentAction( this ); } );

	// handle click on comment delete button
	$jQ( document ).on( 'click', '.comment_delete_link', function(e) { return deleteCommentConfirm( e, this ); } );

	// handle click on confirmation dialog for comment delete button
	$jQ( document ).on( 'click', '.comment_delete_confirmation', function() { return deleteComment( this ); } );

// EVENTS REGARDING CHANGES TO COMMENT PROPERTIES

	// handle hover on textfield 'comments title'
	$jQ( document ).on( 'hover', '.comments_title_inactive', function() { return toggleDisabledElement( this, 'comments_title' ); } );

	// handle click on textfield 'comments title'
	$jQ( document ).on( 'click', '.comments_title_inactive', function() 
	{
		commentsOldTitle = $jQ(this).val();
	});

	// handle keypress on textfield 'comment title'
	$jQ( document ).on( 'keypress', '.comments_title_inactive', function(e) { return confirmChangeWithEnter( e, this ); } );

	// handle blur on textfield 'comment title'
	$jQ( document ).on( 'blur', '.comments_title_inactive', function(e) { return updateCommentsTitle( e, this ); } );

		// handle keypress on textfield entry title
	$jQ( document ).on( 'keyup', '.comment_textarea', function( event ) 
	{ 
		confirmChange( event, 
		{
			onEscape : function()
			{
				$jQ( '.comment_add_cancel' ).click();
			}
		});

	} );

</script>