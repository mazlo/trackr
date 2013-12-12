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

		return View::make( 'ajax.comments' )->with( 'stackr', $stackr );
	}
}