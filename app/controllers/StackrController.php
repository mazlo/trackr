<?php

class StackrController extends BaseController {

	/**
	*	Create the view and pass the given Context
	*/
	public function view( $contextName )
	{
		$context = Auth::user()->context( $contextName )->first();

		if ( isset( $context ) )
			return View::make( 'stackrs' )->with( 'context', $context );
		else
			// TODO create view with error
			return View::make( 'stackrs' )->with( 'context', 'null' );
	}

	/**
	*	Get all Stackrs for User for the given Context
	*/
	public function all( $contextName )
	{
		$stackrs = Auth::user()->stackrs( $contextName )->orderBy( 'favored', 'desc' )->orderBy( 'id', 'desc' )->get();

		return View::make( 'ajax.stackrs' )->with( 'stackrs', $stackrs )->with( 'cname', $contextName );
	}

	public function add( $contextName )
	{
		$context = Auth::user()->context( $contextName )->first();

		// TODO check if context exists

		if ( Input::has( 'tl' ) )
		{
			$stackr = new Stackr();

			// description
			if ( Input::has( 'ds' ) )
				$stackr->description = trim( Input::get( 'ds' ) );

			$stackr->title = trim( Input::get( 'tl' ) );
			$stackr->user()->associate( Auth::user() );
			$stackr->context()->associate( $context );
			$stackr->save();
		}

		return $this->all( $contextName );
	}

	public function details( $contextName, $sid )
	{
		$stackr = Auth::user()->stackr( $sid )->first();

		return View::make( 'stackr' )->with( 'stackr', $stackr );
	}

	public function delete( $contextName, $sid )
	{
		if ( !isset( $contextName ) || !isset( $sid ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();

		// delete all related Comments
        foreach( $stackr->comments as $comment )
        {
            $comment->delete();
        }

        // delete the Stackr
        $stackr->delete();

        return $this->all( $contextName );
	}

	/**
	*	Update Stackr
	*/
	public function update( $contextName, $sid )
	{
		$stackr = Auth::user()->stackr( $sid )->first();

		// update Stackr title
		if ( Input::has( 'tl') )
			$stackr->title = Input::get( 'tl' );

		// update Stackr listTitle
		else if ( Input::has( 'ltl' ) )
			$stackr->listTitle = Input::get( 'ltl' );

		// update Stackr status favored 
		else if ( Input::has( 'fv' ) )
			$stackr->favored = Input::get( 'fv', 0 );

		// update Stackr tags
		else if ( Input::has( 'tg' ) )
			$stackr->tags = Input::get( 'tg' );

		$stackr->save();
	}

}