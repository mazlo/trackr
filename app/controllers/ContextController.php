<?php

class ContextController extends BaseController {

	/**
	*	Loads all contexts for current user
	*/
	public function index()
	{
		// if ajax => return ajax view for all Contexts
		if ( Request::ajax() )
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

		// return just the view
		return View::make( 'contexts' );
	}

	/**
	*	Loads a list of tags defined for that Context
	*/
	function tags( $contextName )
	{
		$tagList = array();

		// get distinct tag list if flag is given
		if ( Input::has( 'ds' ) )
			$tagList = Stackr::distinctTagList( $contextName );

		return View::make( 'ajax.distinctTagList' )->with( 'tagList', $tagList );
	}

	/**
	*	Adds a new Context
	*/
	public function add()
	{

		if ( Input::has( 'tl' ) && Input::has( 'ds' ) )
		{
			$context = new Context();

			$context->name = trim( Input::get( 'tl' ) );
			$context->description = trim( Input::get( 'ds' ) );
			$context->user()->associate( Auth::user() );
			$context->save();
		}

		return $this->index();
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
	*	Delete a Context. 
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

		return $this->index();
	}

	/**
	*
	*/
	public function update( $cname )
	{
		$context = Auth::user()->context( $cname )->first();

		// update color
		if ( Input::has( 'cl') )
		{
			$color = Input::get( 'cl' );

			$context->color = $color;
		}

		$context->save();
	}

}