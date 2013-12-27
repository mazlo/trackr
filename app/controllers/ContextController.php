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

		return View::make( 'ajax.contexts' )->with( 'contexts', $contexts );
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

		if ( empty( $title ) || empty( $desc ))
			return;

		$context = new Context();
		$context->name = $title;
		$context->description = $desc;
		$context->user()->associate( Auth::user() );
		$context->save();

		return $this->all();
	}

}