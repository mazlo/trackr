<?php

class CommentController extends BaseController
{
	
	/**
	*	Loads appropriate Stackr for current User
	*/
	public function index( $contextName, $sid )
	{
		if ( empty( $sid ) )
			return;

		// get Stackr
		$stackr = Auth::user()->stackr( $sid )->first();

		// get Comments from Stackr
		$comments = $stackr->comments()->orderBy( 'position' )->orderby( 'created_at', 'desc' )->get();

		return View::make( 'ajax.comments' )->with( 'stackr', $stackr )->with( 'comments', $comments );
	}

	/**
	*	Add Comment
	*/
	public function add( $contextName, $sid )
	{
		if ( Input::has( 'cmt' ) )
		{
			$comment = new Comment();
			$comment->comment = trim( Input::get( 'cmt' ) );

			if ( Input::get( 'tsk' ) == 'true' )
				$comment->isTask = 1;

			$comment->user()->associate( Auth::user() );

			// associate comment with Stackr
			$stackr = Auth::user()->stackr( $sid )->first();
			$stackr->comments()->save( $comment );
		}

		return $this->index( $contextName, $sid );
	}

	public function delete( $contextName, $sid, $cid )
	{
		if ( empty( $sid ) || empty( $cid ) )
			return;

		// delete Comment
		Auth::user()->comment( $cid )->delete();

		return $this->index( $contextName, $sid );
	}

	/**
	*	Update Comment
	*/
	public function update( $contextName, $sid, $cid = '-1' )
	{
		// update Comment positions
		if ( Input::has( 'cid' ) )
		{
			$cid = Input::get( 'cid' );
			
			for( $i = 0; $i < sizeof( $cid ); ) 
			{
				// get comment for user
				$comment = Auth::user()->comment( $cid[$i] )->first();
				
				if ( !isset( $comment ) )
					continue;

				// update position only
				$comment->position = ++$i;
				$comment->save();
			}

			// finished
			return;
		}

		// prepare Comment
		$comment = Auth::user()->comment( $cid )->first();

		if ( !isset( $comment ) )
			return;

		// update Comment itself
		if ( Input::has( 'cmt') )
		{
			$cmt = Input::get( 'cmt' );

			$comment->comment = $cmt;
			$comment->save();
		}

		// update Comment rating
		else if ( Input::has( 'rt') )
		{
			$rating = Input::get( 'rt' );

			$comment->rating = $rating;
			$comment->save();
		}

		// reloading is done by ajax.success
	}

}