<?php

class ContextController extends BaseController {

	public function view()
	{
		return View::make( 'contexts' );
	}

	/**
	*	Loads all contexts for current user
	*/
	public function all()
	{
		$contexts = Auth::user()->contexts()->get();
		$colors = array();

		foreach( $contexts as $context )
		{
			$colors[ $context->name ] = Color::skip( rand( 1,10 ) )->take(3)->get();
		}

		return View::make( 'ajax.contexts' )
			->with( 'contexts', $contexts )
			->with( 'colors', $colors );
	}

	/**
	*	
	*/
	function distinctTagList( $contextName )
	{
		$tagList = Stackr::distinctTagList( $contextName );

		return View::make( 'ajax.distinctTagList' )->with( 'tagList', $tagList );
	}

	/**
	*	Adds a new Context
	*/
	public function add()
	{
		$title = Input::get( 'tl' );
		$desc = Input::get( 'ds' );

		if ( empty( $title ) || empty( $desc ) )
			return;

		$context = new Context();
		$context->name = $title;
		$context->description = $desc;
		$context->user()->associate( Auth::user() );
		$context->save();

		return $this->all();
	}

	/**
	*	Creates a Context from an existing Stackr.
	*/
	public function make()
	{
		$sid = Input::get( 'sid' );
		$duplicate = Input::get( 'dpl' );

		if ( empty( $sid ) )
			return;

		if ( empty( $duplicate ) )
			$duplicate = false;

		$stackr = Auth::user()->stackr( $sid )->first();

		if ( !isset( $stackr ) )
			return;

		$context = new Context();
		$context->name = trim( $stackr->title );
		$context->description = trim( $stackr->description );
		$context->user()->associate( Auth::user() );

		// save Context, so it has a primary key
		$context->save();

		if ( $duplicate == true )
		{
			// duplicate stackr and associate with Context
			$clonedStackr = $stackr->replicate();
			$clonedStackr->context()->associate( $context );
			$clonedStackr->save();
		}

		$this->all();
	}

	/**
	*	Delete a Context
	*/
	public function delete( $cname )
	{
		// get Context
		$context = Auth::user()->context( $cname )->first();

		// get all Stackrs and delete Comments
		$stackrs = $context->stackrs()->get();

		foreach ( $stackrs as $stackr ) 
		{
			$comments = $stackr->comments()->get();

			// delete all Comments
			foreach ( $comments as $comment ) 
			{
				$comment->delete();
			}

			// finally, delete Stackr
			$stackr->delete();
		}

		// finally, delete Context
		$context->delete();

		return $this->all();
	}

}