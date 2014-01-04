
var getContextPath = function()
{
	var contextPathArr = window.location.pathname.split( '/' );
	
	if ( contextPathArr == undefined )
		return '';
	
	if ( contextPathArr.length > 2 )
		return '/' + contextPathArr[1] + '/' + contextPathArr[2];

	if ( contextPathArr.length > 1 )
		return '/' + contextPathArr[1];
};

var getContexts = function()
{
	$jQ.ajax( {
		url: getContextPath() +'/contexts/all',
		type: 'get',

		success: function( data ) 
		{
			var contextsContainer = $jQ( '#contexts' );

			contextsContainer.hide();
			contextsContainer.html( data );
			contextsContainer.fadeIn( 200 );
		}
	});
}

var getAllEntries = function( tags )
{
	var cname = $jQ( '#entries' ).attr( 'cname' );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/all',
		type: 'get',
		data: { ts: tags },

		success: function( data ) 
		{
			$jQ( '#entries' ).html( data );

			makeCommentsSortable( this );
		}
	});
};

var makeCommentsSortable = function( object )
{
	$jQ( '.comments' ).sortable( 
	{
		update: function( event, ui ) 
		{
			return updateCommentPositions( object );
		}
	});

	$jQ( '.comments' ).disableSelection();
};

var getDistinctEntriesTagList = function()
{
	var cname = $jQ( '#entries' ).attr( 'cname' );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/distinctTagList',
		type: 'get',

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
	var cname = $jQ( '#entries' ).attr( 'cname' );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ eid +'/comments',
		type: 'get',

		success: function( data ) 
		{
			$jQ( '#comments_'+ eid ).html( data );
		}
	});
};

// ----- update functions for entries and comments -----

var updateCommentPositions = function( object )
{
	var counter = 0;
	var cid = [];
	var pos = [];

	$jQ( object ).find( '.comment' ).each( function()
	{
		cid.push( $jQ(this).attr( 'cid' ) );
		pos.push( ++counter );
	});

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = getClosestEntryId( object );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/comments/reorder',
		type: 'post',
		data: { cid: cid, pos: pos }
	});
};

var updateEntryTitle = function( e, object )
{
	var title = $jQ( object ).val();

	if ( oldTitle == title )
		return;

	// prepare confirmation dialog
	var x = e.target.offsetLeft - 187;
	var y = e.target.offsetTop + 1;

	var dialog = $jQ( object ).next( '.entry_title_confirm' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	// ajax call to change title
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/changeTitle',
		type: 'post',
		data: { tl: title },

		success: function( data ) 
		{
			dialog.show();
			dialog.effect( 'fade', 2000, function() 
			{
				$jQ(this).hide();
			} );
		}
	});
};

var updateCommentsTitle = function( e, object )
{
	var title = $jQ( object ).val();

	if ( commentsOldTitle == title )
		return;

	// prepare confirmation dialog
	var x = e.target.offsetLeft - 187;
	var y = e.target.offsetTop + 1;

	var dialog = $jQ( object ).next( '.comments_title_confirm' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	// ajax call to change title
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/changeListTitle',
		type: 'post',
		data: { tl: title },

		success: function( data ) 
		{
			// change button label
			if ( title.charAt( title.length-1 ) == 's' ) 
  				title = title.slice( 0, -1 );

			$jQ( '#comment_add_button_text_'+ entryId ).text( title );

			// show confirmation dialog
			dialog.show();
			dialog.effect( 'fade', 2000, function() 
			{
				$jQ(this).hide();
			} );
		}
	});
};

var updateTags = function ( object )
{
	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	var tags = $jQ( object ).val();

	// ajax call to change tags
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/changeTags',
		type: 'post',
		data: { ts: tags },

		success: function( data ) 
		{
			// update tags attribute on wrapper_entry
			$jQ( object ).closest( '.wrapper_entry' ).attr( 'tags', tags );

			// compute distinct tag list anew
			getDistinctEntriesTagList();
		}
	});
};

var updateEntryFavored = function ( object )
{
	var type = $jQ( object ).attr( 'alt' );

	$jQ( object ).attr( 'src', getContextPath() + '/resources/pinIt_'+ inverseFavored(type) +'.png' );
	$jQ( object ).attr( 'alt', inverseFavored(type) );

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	// ajax call to change favored status
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/changePinStatus',
		type: 'post',
		data: { fv: inverseFavored(type) }
	});			
};

// ----- functions regarding contexts -----

var addContextAction = function()
{
	var title = $jQ( '#title' ).val();
	if ( title == '' )
	{
		$jQ( '#title_error' ).text( 'You forgot to fill this in!' );
		return false;
	}

	// 1. replace all characters that are not allowed
	// 2. replace all subsequent not allowed characters with min-length 2
	title = title.replace( /[^a-zA-z0-9]+/g, '-' ).replace( /([^a-zA-Z0-9]){2}/g, '' )

	var description = $jQ( '#description' ).val();
	if ( description == '' )
	{
		$jQ( '#description_error' ).text( 'You forgot to fill this in!' );
		return false;
	}

	$jQ.ajax( {
		url: getContextPath() + '/contexts/add',
		type: 'post',
		data: { tl: title, ds: description },

		success: function( data ) 
		{
			$jQ( '#div_context_add' ).hide();

			var contextsContainer = $jQ( '#contexts' );
			
			contextsContainer.hide();
			contextsContainer.html( data );
			contextsContainer.fadeIn( 200 );
		}
	});

	return false;
}

var deleteContextConfirm = function( e, object )
{
	var x = e.target.offsetLeft - 2;
	var y = e.target.offsetTop + 42;

	var dialog = $jQ( object ).next( '.context_delete_confirmation' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );
	dialog.show();

	setTimeout( function() { $jQ( dialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var deleteContext = function( object, closestClass )
{
	$jQ( object ).hide();

	var cname = $jQ( object ).closest( closestClass ).attr( 'cname' );

	$jQ( object ).closest( closestClass ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: getContextPath() +'/contexts/'+ cname,
				type: 'delete'
			});
		});

	return false;
};

var updateContextColor = function( object, closestClass )
{
	var cname = $jQ( object ).closest( closestClass ).attr( 'cname' );
	var color = $jQ( object ).attr( 'color' );

	$jQ( object ).closest( '.wrapper_context' ).find( '.context' ).css( 'background', color );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname,
		type: 'put',
		data: { cl: color }
	});
};

// ----- functions regarding entries -----

var addEntryAction = function() 
{
	var title = $jQ( '#title' ).val();
	if ( title == '' )
		return false;

	var description = $jQ( '#description' ).val();

	var cname = $jQ( '#entries' ).attr( 'cname' );

	$jQ.ajax( {
		url: getContextPath() + '/contexts/'+ cname +'/stackrs/add',
		type: 'post',
		data: { tl: title, ds: description },

		success: function( data ) 
		{
			$jQ( '#div_entry_add' ).hide();

			var entriesContainer = $jQ( '#entries' );
			
			entriesContainer.hide();
			entriesContainer.html( data );
			entriesContainer.fadeIn( 200 );

			makeCommentsSortable( this );
		}
	});

	return false;
};


var deleteEntryConfirm = function( e, object ) 
{
	var x = e.target.offsetLeft + 1;
	var y = e.target.offsetTop + 42;

	var dialog = $jQ( object ).next( '.entry_delete_confirmation' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );
	dialog.show();

	setTimeout( function() { $jQ( dialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var deleteEntry = function( object, closestClass, callback )
{
	$jQ( object ).hide();

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	$jQ( object ).closest( closestClass ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId,
				type: 'delete',

				success: function( data ) 
				{
					callback();
				}
			});
		});

	return false;
};

var makeContextConfirm = function( e, object )
{
	$jQ( '#context-make-confirm-dialog' ).dialog(
	{
		title: "Simply Create Context?",
		resizable: false,
		height: 320,
		width: 480,
		modal: true,
		buttons: 
		{
			"Create Context" : function() 
			{
				makeContext( object, false, function()
				{
					window.location = getContextPath() + '/contexts';
				} );
			},
			"Create Context and copy Stackr": function() 
			{
				makeContext( object, true, function()
				{
					window.location = getContextPath() + '/contexts';
				} );
			},
			"Cancel": function()
			{
				$jQ( this ).dialog( "close" );	
			}
		}
	});
};

var makeContext = function( object, copy, callback )
{
	var sid = $jQ( object ).attr('eid');

	$jQ.ajax( {
		url: getContextPath() +'/contexts/make',
		type: 'post',
		data: { sid: sid, dpl: copy },

		success: function( data ) 
		{
			callback();
		}
	});

	return false;
};

// ----- functions regarding comments -----

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
	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );

	if ( $jQ( '#comment_new_content_'+ entryId ).val() == '' )
		return;

	var comment = $jQ( '#comment_new_content_'+ entryId ).val();

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/comments/add',
		type: 'post',
		data: { cmt: comment },

		success: function( data ) 
		{
			$jQ( '#comment_add_link_'+ entryId ).hide();
			$jQ( '#comments_'+ entryId ).html( data );
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

	var cname = $jQ( '#entries' ).attr( 'cname' );
	var entryId = $jQ( object ).attr( 'eid' );
	var commentId = $jQ( object ).attr( 'cid' );

	$jQ( object ).closest( '.comment' ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ entryId +'/comments/'+ commentId,
				type: 'delete',

				success: function( data ) 
				{
					$jQ( '#comments_'+ entryId ).html( data );
				}
			});
		});

	return false;
};

var seeMoreComments = function( object )
{
	// hide current wrapper element
	$jQ( object ).parent().effect( 'fade', 100, function()
	{
		$jQ(this).hide();
	});

	// get element id and request comments
	var sid = $jQ( object ).closest( '.wrapper_entry' ).attr( 'eid' );

	getComments( sid );

	return false;
};

// ----- keypress events -----

var confirmChange = function( event, handler )
{
	if ( event == undefined || handler == undefined )
		return;

	if ( event.which == 13 ) 
	{
		if ( handler.onEnter != undefined )
			handler.onEnter();
	}
	else if ( event.which == 27 ) 
	{
		if ( handler.onEscape != undefined )
			handler.onEscape();
	}
};

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
		$jQ( object ).val( $jQ( object ).val().replace( /^,|, ?$/g, '' ) );

		$jQ( object ).blur();

		return;
	} 

	// on press of space
	else if ( e.which == 32 )
	{
		// replace space by comma space
		$jQ( object ).val( $jQ( object ).val().replace( / /g, ', ' ) );

		// replace double comma by comma
		$jQ( object ).val( $jQ( object ).val().replace( /,,/g, ',' ) );

		return;
	} 

	// on press of comma
	else if ( e.which == 188 )
	{
		// replace double comma by comma
		var value = $jQ( object ).val().replace( /,,/g, ',' );
		$jQ( object ).val(value);
	}
};

// ----- css manipulations -----

var toggleDisabledElement = function( object, classToBeToggled ) 
{
	$jQ( object ).toggleClass( classToBeToggled );
	$jQ( object ).removeAttr( 'disabled' );
};

// ----- global functions -----

var showDiv = function( element ) 
{
	$jQ( '#title_error' ).text( '' );
	$jQ( '#description_error' ).text( '' );

	$jQ( element ).effect( 'fade', 200, function() 
	{
		$jQ( element ).show();
		$jQ( '#title' ).focus();
	} );

	return false;
};

var hideDiv = function( element )
{
	$jQ( element ).effect( 'fade', 100, function()
	{
		$jQ( element ).hide();
	});

	return false;	
}

var inverseFavored = function( key )
{
	if ( key == 0 )
		return 1;
	if ( key == 1 )
		return 0;
};

var getClosestEntryId = function( object )
{
	return $jQ( object ).closest( '.wrapper_entry' ).attr( 'eid' );
};

