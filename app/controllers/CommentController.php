<?php

class CommentController extends BaseController
{
	
	public function getAll( $eid )
	{
		if ( empty( $eid ) )
			return;

		$stackr = Stackr::find( $eid );

		return View::make( 'ajax.comments' )->with( 'stackr', $stackr );
	}

	public function add( $eid )
	{
		$cmt = Input::get( 'cmt' );

		if ( empty( $eid ) || empty( $cmt ) )
			return;

		$comment = new Comment();
		$comment->comment = $cmt;

		$stackr = Stackr::find( $eid );
		$stackr->comments()->save( $comment );

		return $this->getAll( $eid );
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