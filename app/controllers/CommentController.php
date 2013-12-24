<?php

class CommentController extends BaseController
{
	
	public function all( $cname, $eid )
	{
		if ( empty( $cname ) || empty( $eid ) )
			return;

		$stackr = Auth::user()->stackr( $cname, $eid )->first();

		return View::make( 'ajax.comments' )->with( 'stackr', $stackr );
	}

	public function add( $cname, $eid )
	{
		$cmt = Input::get( 'cmt' );

		if ( empty( $cname ) || empty( $eid ) || empty( $cmt ) )
			return;

		$comment = new Comment();
		$comment->comment = $cmt;
		$comment->user()->associate( Auth::user() );

		$stackr = Auth::user()->stackr( $cname, $eid )->first();
		$stackr->comments()->save( $comment );

		return $this->all( $cname, $eid );
	}

	public function delete( $eid, $cid )
	{
		if ( empty( $eid ) || empty( $cid ) )
			return;

		// delete Comment
		Comment::find( $cid )->delete();

		// load current stackr
		$stackr = Stackr::find( $eid );

		return $this->getAll( $eid );
	}

	public function reorder()
	{
		$cids = Input::get( 'cid' );
		$poss = Input::get( 'pos' );

		if ( empty( $cids ) || empty( $poss) )
			return;

		for( $i = 0; $i < sizeof( $cids ); $i++ ) 
		{
			$comment = Comment::find( $cids[$i] );
			$comment->position = $poss[$i];
			$comment->save();
		}

		// reloading is done by ajax.success
	}

}