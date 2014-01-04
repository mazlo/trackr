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
		$title = Input::get( 'tl' );
		$desc = Input::get( 'ds' );

		if ( empty( $contextName ) || empty( $title ) )
			return;

		$context = Auth::user()->context( $contextName )->first();

		// TODO check if context exists

		$stackr = new Stackr();
		$stackr->title = trim( $title );
		$stackr->description = trim( $desc );
		$stackr->user()->associate( Auth::user() );
		$stackr->context()->associate( $context );
		$stackr->save();

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

	public function changeTitle( $contextName, $sid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $sid ) || empty( $title ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();
		$stackr->title = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeListTitle( $contextName, $sid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $sid ) || empty( $title ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();
		$stackr->listTitle = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}	

	public function changePinStatus( $contextName, $sid )
	{
		$pinned = Input::get( 'fv', 0 );

		$stackr = Auth::user()->stackr( $sid )->first();
		$stackr->favored = $pinned;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeTags( $contextName, $sid )
	{
		$tags = Input::get( 'ts' );

		if ( empty( $tags ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();
		$stackr->tags = $tags;
		$stackr->save();

		// the reload is done by ajax.success()
	}

}