
var getAllEntries = function( tags )
{
	$jQ.ajax( {
		url: "getAllEntries.php",
		type: "get",
		data: { ts: tags },

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

var getDistinctEntriesTagList = function( )
{
	$jQ.ajax( {
		url: "getDistinctEntriesTagList.php",
		type: "get",

		success: function( data )
		{
			$jQ( '#distinctEntriesTagList' ).html( data );

			// transform to jquery button
			$jQ( '.entry_tag' ).button();
		}
	});
}

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
		type: "post",
		data: { cid: cid, pos: pos }
	});
};

var updateTags = function ( object )
{
	var entryId = $jQ(object).attr( 'eid' );
	var tags = $jQ(object).val();

	// ajax call to change tags
	$jQ.ajax( {
		url: "changeEntryTags.php",
		type: "post",
		data: { eid: entryId, ts: tags },

		success: function( data ) 
		{
			getAllEntries();
			getDistinctEntriesTagList();
		}
	});
};

var updateEntryFavored = function ( object )
{
	var type = $jQ(object).attr( 'alt' );

	$jQ(object).attr( 'src', 'resources/pinIt_'+ inverseFavored(type) +'.png' );
	$jQ(object).attr( 'alt', inverseFavored(type) );

	var entryId = $jQ(object).attr( 'eid' );

	// ajax call to change favored status
	$jQ.ajax( {
		url: "changeEntryFavored.php",
		type: "post",
		data: { eid: entryId, fv: inverseFavored(type) }
	});			
};

var deleteEntryConfirm = function( e, object ) 
{
	var x = e.target.offsetLeft - 100;
	var y = e.target.offsetTop + 1;

	var dialog = $jQ( object ).next( '.entry_delete_confirmation' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );
	dialog.show();

	setTimeout( function() { $jQ( dialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var showAddEntryDiv = function() 
{
	$jQ( '#div_entry_add' ).effect( 'fade', 200, function() 
	{
		$jQ( '#div_entry_add' ).show();
		$jQ( '#title' ).focus();
	} );

	return true;
};

var hideAddEntryDiv = function()
{
	$jQ( '#div_entry_add' ).effect( 'fade', 100, function()
	{
		$jQ( '#div_entry_add' ).hide();
	});

	return false;
};

var addEntryAction = function() 
{
	var title = $jQ( '#title' ).val();
	if ( title == "" )
		return false;

	var description = $jQ( '#description' ).val();

	$jQ.ajax( {
		url: "addEntry.php",
		type: "post",
		data: { tl: title, ds: description },

		success: function( data ) 
		{
			$jQ( "#div_entry_add" ).hide();
			getAllEntries();
		}
	});

	return false;
};

var deleteEntry = function( object, closestClass, callback )
{
	$jQ( object ).hide();

	var elementId = $jQ( object ).attr( 'eid' );

	$jQ( object ).closest( closestClass ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: "deleteEntry.php",
				type: "post",
				context: document.body,
				data: { eid: elementId },

				success: function( data ) 
				{
					callback();
				}
			});
		});

	return false;
};

var showAddCommentDiv = function( object )
{
	var entryId = $jQ( object ).attr('eid');

	$jQ( '#comment_add_link_'+ entryId ).effect( 'fade', 200, function()
		{
			$jQ( '#comment_add_link_'+ entryId ).show();
			$jQ( '#comment_new_content_'+ entryId ).focus();
		});

	return false;
};

var hideAddCommentDiv = function( object ) 
{
	var entryId = $jQ( object ).attr('eid');
	$jQ( '#comment_add_link_'+ entryId ).effect( 'fade', 100, function()
		{
			$jQ( '#comment_add_link_'+ entryId ).hide();
		} );

	return false;
};

var addCommentAction = function( object )
{
	var entryId = $jQ( object ).attr('eid');

	if ( $jQ( '#comment_new_content_'+ entryId ).val() == "" )
		return;

	var comment = $jQ( '#comment_new_content_'+ entryId ).val();

	$jQ.ajax( {
		url: "addComment.php",
		type: "post",
		data: { eid: entryId, cm: comment },

		success: function( data ) 
		{
			$jQ( '#comment_add_link_'+ entryId ).hide();
			getComments( entryId );
		}
	});

	return false;
};

var deleteCommentConfirm = function( e, object )
{
	var x = e.target.offsetLeft - 188;
	var y = e.target.offsetTop + 1;

	var cdialog = $jQ( object ).parent().nextAll( '.comment_delete_confirmation' );
	cdialog.css( 'left', x );
	cdialog.css( 'top', y );
	cdialog.show();

	setTimeout( function() { $jQ( cdialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var deleteComment = function( object )
{
	$jQ( object ).hide();

	var entryId = $jQ( object ).attr( 'eid' );
	var commentId = $jQ( object ).attr( 'cid' );

	$jQ( object ).closest( '.comment' ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: "deleteComment.php",
				type: "post",
				context: document.body,
				data: { eid: entryId, cid: commentId },

				success: function( data ) 
				{
					getComments( entryId );
				}
			});
		});

	return false;
};

// ----- keypress events -----

var confirmChangeWithEnter = function( e, object )
{
	// on press of enter
	if ( e.which == 13 )
		$jQ( object ).blur();
};

var confirmChangeOfTags = function( e, object )
{
	// on press of enter
	if ( e.which == 13 )
	{
		// replace trailing white space and comma
		$jQ(object).val( $jQ(object).val().replace( /^,|, ?$/g, '' ) );

		$jQ(object).blur();

		return;
	} 

	// on press of space
	else if ( e.which == 32 )
	{
		// replace space by comma space
		$jQ(object).val( $jQ(object).val().replace( / /g, ', ' ) );

		// replace double comma by comma
		$jQ(object).val( $jQ(object).val().replace( /,,/g, ',' ) );

		return;
	} 

	// on press of comma
	else if ( e.which == 188 )
	{
		// replace double comma by comma
		var value = $jQ(object).val().replace( /,,/g, ',' );
		$jQ(object).val(value);
	}
};

// ----- css manipulations -----

var toggleDisabledElement = function( object, classToBeToggled ) 
{
	$jQ( object ).toggleClass( classToBeToggled );
	$jQ( object ).removeAttr( 'disabled' );
};

// ----- global functions -----

var inverseFavored = function( key )
{
	if ( key == 0 )
		return 1;
	if ( key == 1 )
		return 0;
};

