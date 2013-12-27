<?php

class CommentController extends BaseController
{
	
	public function all( $contextName, $sid )
	{
		if ( empty( $sid ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();

		return View::make( 'ajax.comments' )->with( 'stackr', $stackr );
	}

	public function add( $contextName, $sid )
	{
		$cmt = Input::get( 'cmt' );

		if ( empty( $sid ) || empty( $cmt ) )
			return;

		$comment = new Comment();
		$comment->comment = $cmt;
		$comment->user()->associate( Auth::user() );

		// add new Comment to existing Stackr
		$stackr = Auth::user()->stackr( $sid )->first();
		$stackr->comments()->save( $comment );

		return $this->all( $contextName, $sid );
	}

	public function delete( $contextName, $sid, $cid )
	{
		if ( empty( $sid ) || empty( $cid ) )
			return;

		// delete Comment
		Auth::user()->comment( $cid )->delete();

		return $this->all( $contextName, $sid );
	}

	public function reorder( $contextName, $sid )
	{
		$cids = Input::get( 'cid' );
		$poss = Input::get( 'pos' );

		if ( empty( $cids ) || empty( $poss) )
			return;

		for( $i = 0; $i < sizeof( $cids ); $i++ ) 
		{
			// get comment for user
			$comment = Auth::user()->comment( $cids[$i] )->first();
			
			if ( !isset( $comment ) )
				continue;

			// update position only
			$comment->position = $poss[$i];
			$comment->save();
		}

		// reloading is done by ajax.success
	}

}