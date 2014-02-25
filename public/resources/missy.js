
var getContextPath = function()
{
	var contextPathArr = window.location.pathname.split( '/' );

	if ( contextPathArr == undefined )
		return '';

	// testing environment
	if ( contextPathArr.length > 1 )
		if ( contextPathArr[1] == 'public' )
			return '/' + contextPathArr[1];

	// production
	return '';
};

var getContexts = function()
{
	$jQ.ajax( {
		url: getContextPath() +'/contexts',
		type: 'get',

		success: function( data ) 
		{
			var contextsContainer = $jQ( '#contexts' );

			contextsContainer.hide();
			contextsContainer.html( data );
			contextsContainer.fadeIn( 200 );

			makeContextsSortable();
		}
	});
}

var getAllEntries = function( tags )
{
	var cname = getContextName();

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs',
		type: 'get',
		data: { ts: tags },

		success: function( data ) 
		{
			$jQ( '#stackrs' ).html( data );

			scrollToDesiredElement();
			makeCommentsSortable( null );
		}
	});
};

var scrollToDesiredElement = function()
{
	var anchorId = window.location.toString().split( '#' );

	if ( anchorId.length == 1 )
		return;

	var element = $jQ( '#'+ anchorId[1] );

	$jQ( 'html, body' ).animate({ 
		scrollTop: element.offset().top - 72
	}, 100 );

	element.effect( 'highlight', { }, 800 );
};

var makeContextStackrsSortable = function()
{
	$jQ( '.list-contexts-stackrs' ).sortable(
	{
		disabled: false,
		connectWith: '.list-contexts-stackrs',
		receive: function( event, ui )
		{
			updateStackrContext( this, ui.item );
		}
	});
};

var makeContextsSortable = function() 
{
	$jQ( '#contexts' ).sortable( 
	{
		disabled: false,
		update: function( event, ui ) 
		{
			return updateContextPositions( this );
		}
	});

	$jQ( '#contexts' ).disableSelection();
}

var makeCommentsSortable = function( object )
{
	$jQ( '.comments' ).sortable( 
	{
		update: function( event, ui ) 
		{
			if ( object )
				return updateCommentPositions( object );
			else 
				return updateCommentPositions( this );
		}
	});

	$jQ( '.comments' ).disableSelection();
};

var getDistinctEntriesTagList = function()
{
	var cname = getContextName();

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/tags',
		type: 'get',
		data: { ds: 1 },

		success: function( data )
		{
			$jQ( '#stackrs-tag-list' ).html( data );

			// transform to jquery button
			$jQ( '.stackr-tag' ).button();
		}
	});
}

var getComments = function( sid, callback )
{
	var cname = getContextName();

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments',
		type: 'get',

		success: function( data ) 
		{
			$jQ( '#comments-'+ sid ).html( data );

			if ( callback )
				callback();
		}
	});
};

// ----- update functions for contexts, stackrs, comments -----

var updateContextPositions = function( object )
{
	var counter = 0;
	var cid = [];

	// collect all ids in the correct order
	$jQ( object ).find( '.context' ).each( function()
	{
		cid.push( $jQ(this).parent().attr( 'cname' ) );
	});

	// send put request
	$jQ.ajax( {
		url: getContextPath() +'/contexts',
		type: 'put',
		data: { cid: cid }
	});
};

var updateStackrContext = function( container, stackr )
{
	var cname = $jQ(container).closest( '[cname]' ).attr( 'cname' );
	var sid = $jQ(stackr).text().trim().split( '#' )[1];

	// send put request
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname + '/stackrs/'+ sid,
		type: 'put',
		data: { cname: cname }
	});
};

var updateComment = function( object )
{
	// forget old comment that was saved before
	oldComment = null;

	var newComment = $jQ( object ).parent().find( 'textarea' ).val();

	// get element ids
	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );
	var commentId = $jQ( object ).closest( 'li' ).attr( 'cid' );

	// compose put request
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments/'+ commentId,
		type: 'put',
		data: { cmt: newComment }
	});

	// workaround: after submitting with click on button the mouseover-event get's inverted.
	// this call brings it back to the normal state
	$jQ( object ).closest( '.comments' ).mouseout();

	// turn textarea back to simple span
	$jQ( object ).parent().html( newComment );
};

var updateCommentPositions = function( object )
{
	var counter = 0;
	var cid = [];

	$jQ( object ).find( '.comment' ).each( function()
	{
		cid.push( $jQ(this).attr( 'cid' ) );
	});

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments',
		type: 'put',
		data: { cid: cid }
	});
};

var updateCommentRating = function( object, counter )
{
	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );
	var commentId = $jQ( object ).closest( 'li' ).attr( 'cid' );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments/'+ commentId,
		type: 'put',
		data: { rt: counter }
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

	var dialog = $jQ( object ).next( '.operator-button-done' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	// ajax call to change title
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid,
		type: 'put',
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

	var dialog = $jQ( object ).next( '.operator-button-done' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	// ajax call to change title
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid,
		type: 'put',
		data: { ltl: title },

		success: function( data ) 
		{
			// change button label
			if ( title.charAt( title.length-1 ) == 's' ) 
  				title = title.slice( 0, -1 );

			$jQ( '#comment_add_button_text_'+ sid ).text( title );

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
	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	var tags = $jQ( object ).val();

	if ( tags == '' )
		tags = '-';

	// ajax call to change tags
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid,
		type: 'put',
		data: { tg: tags },

		success: function( data ) 
		{
			// update tags attribute on stackr-wrapper
			$jQ( object ).closest( '.stackr-wrapper' ).attr( 'tags', tags );

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

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	// ajax call to change favored status
	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid,
		type: 'put',
		data: { fv: inverseFavored(type) }
	});			
};

// ----- functions regarding contexts -----

var addContextAction = function()
{
	var title = $jQ( '#context-title' ).val();
	if ( title == '' )
	{
		$jQ( '.title-error' ).text( 'You forgot to fill this in!' );
		return false;
	}

	// 1. replace all characters that are not allowed
	// 2. replace all subsequent not allowed characters with min-length 2
	title = title.replace( /[^a-zA-z0-9äöü]+/g, '-' ).replace( /([^a-zA-Z0-9äöü]){2}/g, '' )

	var description = $jQ( '#context-description' );

	// when empty -> replace value with default text from placeholder attribute
	if ( description.val() == '' )
		description.val( description.attr( 'placeholder') );

	$jQ.ajax( {
		url: getContextPath() + '/contexts',
		type: 'post',
		data: { tl: title, ds: description.val() },

		success: function( data ) 
		{
			$jQ( '#section-context-add' ).hide();

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
	var y = e.target.offsetTop - 32;

	var dialog = $jQ( object ).next( '.context-delete-confirm' );
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

	$jQ( object ).closest( closestClass ).find( '.context' ).css( 'background', color );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname,
		type: 'put',
		data: { cl: color }
	});
};

// ----- functions regarding entries -----

var addEntryAction = function( addNext ) 
{
	var title = $jQ( '#stackr-title' ).val();
	if ( title == '' )
		return false;

	var description = $jQ( '#stackr-description' ).val();

	var cname = getContextName();

	$jQ.ajax( {
		url: getContextPath() + '/contexts/'+ cname +'/stackrs',
		type: 'post',
		data: { tl: title, ds: description },

		success: function( data ) 
		{
			$jQ( '#section-stackr-add' ).hide();

			var container = $jQ( '#stackrs' );
			
			container.hide();
			container.html( data );
			container.fadeIn( 200 );

			makeCommentsSortable( this );

			if( addNext )
				showDiv( '#section-stackr-add' );
		}
	});

	return false;
};


var deleteEntryConfirm = function( e, object ) 
{
	var x = e.target.offsetLeft + 1;
	var y = e.target.offsetTop + 42;

	var dialog = $jQ( object ).next( '.stackr-delete-confirm' );
	dialog.css( 'left', x );
	dialog.css( 'top', y );
	dialog.show();

	setTimeout( function() { $jQ( dialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var deleteEntry = function( object, closestClass, callback )
{
	$jQ( object ).hide();

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );

	$jQ( object ).closest( closestClass ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid,
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
	var sid = getIdFromClosestStackr( object );

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

var filterCommentsByTask = function( object )
{
	var sid = getIdFromClosestStackr( object );

	// get the label element and check for state active
	var activeButton = $jQ( object ).hasClass( 'operator-button-state-active' );

	$jQ( '#comments-'+ sid +' > .comment' ).each( function()
	{
		$jQ( this ).show();

		if ( !activeButton )
			return;

		var taskAttr = $jQ( this ).attr( 'istask' );
		var hasTaskAttr = ( typeof taskAttr !== 'undefined' && taskAttr !== false );

		if ( !hasTaskAttr )
			$jQ( this ).hide();
	});
};

// ----- functions regarding comments -----

var showCommentAddDiv = function( object )
{
	var sid = getIdFromClosestStackr( object );
	var elementId = '#section-comment-add-'+ sid;

	// reset toggable buttons
	$jQ( elementId ).find( '.operator-button-state-active' ).click();

	$jQ( elementId ).effect( 'fade', 200, function()
	{
		$jQ( elementId ).show();
		$jQ( '#comment-add-'+ sid ).select().focus();
	});

	return false;
};

var hideAddCommentDiv = function( object ) 
{
	var sid = getIdFromClosestStackr( object );
	var elementId = '#section-comment-add-'+ sid;

	$jQ( elementId ).effect( 'fade', 100, function()
		{
			$jQ( elementId ).hide();
		} );

	return false;
};

var addCommentAction = function( object, addNext )
{
	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );
	var textareaId = '#comment-add-'+ sid;

	if ( $jQ( textareaId ).val() == '' )
		return;

	// get comment
	var comment = $jQ( textareaId ).val();

	// and task flag
	var taskButton = $jQ( object ).parent().prev();
	var taskButtonActive = taskButton.hasClass( 'operator-button-state-active' );

	$jQ.ajax( {
		url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments',
		type: 'post',
		data: { cmt: comment, tsk: taskButtonActive },

		success: function( data ) 
		{
			$jQ( '#comments-'+ sid ).html( data );

			// deactivate button when active
			if ( taskButtonActive )
				taskButton.click();

			// deactivate filter task-button after adding Comment
			var filterTaskButton = $jQ( '#'+ sid ).find( '.stackr-filter-tasks' );

			if ( filterTaskButton.hasClass( 'operator-button-state-active' ) ) 
				filterTaskButton.toggleClass( 'operator-button-state-active' );

			// hide section when no other Comment should be added
			if ( !addNext )
				$jQ( '#section-comment-add-'+ sid ).hide();

			$jQ( textareaId ).select().focus();
		}
	});

	return false;
};

var deleteCommentConfirm = function( e, object )
{
	var x = e.target.offsetLeft - 188;
	var y = e.target.offsetTop + 1;

	var cdialog = $jQ( object ).parent().nextAll( '.comment-delete-confirm' );
	cdialog.css( 'left', x );
	cdialog.css( 'top', y );
	cdialog.show();

	setTimeout( function() { $jQ( cdialog ).effect( 'fade', 1000 ); }, 2000 );

	return false;
};

var deleteComment = function( object )
{
	$jQ( object ).hide();

	var cname = getContextName();
	var sid = getIdFromClosestStackr( object );
	var commentId = $jQ( object ).attr( 'cid' );

	$jQ( object ).closest( '.comment' ).effect( 'fade', 300, function()
		{
			$jQ.ajax( {
				url: getContextPath() +'/contexts/'+ cname +'/stackrs/'+ sid +'/comments/'+ commentId,
				type: 'delete',

				success: function( data ) 
				{
					$jQ( '#comments-'+ sid ).html( data );
				}
			});
		});

	return false;
};

var seeMoreComments = function( object )
{
	var sid = getIdFromClosestStackr( object );

	// remove link and show loading image
	$jQ( object ).remove();
	$jQ( '#comments-loader-img-'+ sid ).show();

	// load comments
	getComments( sid, function() 
	{
		// workaround: after submitting with click on button the mouseover-event get's inverted.
		// this call brings it back to the normal state
		$jQ( '#'+ sid ).find( '.section-hoverable' ).toggleClass( 'section-hoverable-active' );

		// find filter tasks button 
		var filterButton = $jQ( '#'+ sid ).find( '.stackr-filter-tasks' );
		var filterButtonActive = filterButton.hasClass( 'operator-button-state-active' );

		// filter Comments by task when active
		if ( filterButtonActive )
			filterCommentsByTask( filterButton );

		// find show dates button
		var datesButton = $jQ( '#'+ sid ).find( '.stackr-show-dates' );
		var datesButtonActive = datesButton.hasClass( 'operator-button-state-active' );

		// show Comment dates when active
		if ( datesButtonActive )
			toggleCommentDates( datesButton );
	} );

	return false;
};

var toggleCommentDates = function( object )
{
	var sid = getIdFromClosestStackr( object );

	$jQ( '#'+ sid ).find( '.comment-date' ).toggleClass( 'element-hidden-active' ); 
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

var showDiv = function( element, elementToFocus ) 
{
	$jQ( '.title-error' ).text( '' );
	$jQ( '.description-error' ).text( '' );

	// clean textarea
	$jQ( element ).children( '.textarea' ).val( '' );

	// show element with effect
	$jQ( element ).effect( 'fade', 200, function() 
	{
		if ( elementToFocus )
		{
			// select text in element to be ready to be overwritten
			var focusableElement = $jQ( this ).children( elementToFocus );
			focusableElement.select().focus();
		}

		$jQ( element ).show();
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

var getIdFromClosestStackr = function ( object )
{
	return $jQ( object ).closest( '.stackr-wrapper' ).attr( 'id' );
}

var getContextName = function()
{
	return $jQ( '#stackrs' ).attr( 'cname' );
}

