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

		if ( empty( $contextName ) || empty( $title ) || empty( $desc ))
			return;

		$context = Auth::user()->context( $contextName )->first();

		// TODO check if context exists

		$stackr = new Stackr();
		$stackr->title = $title;
		$stackr->description = $desc;
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

	public function delete( $cnid, $eid )
	{
		if ( !isset( $cnid ) || !isset( $eid ) )
			return;

		$stackr = Auth::user()->stackr( $eid )->first();

		// delete all related Comments
        foreach( $stackr->comments as $comment )
        {
            $comment->delete();
        }

        // delete the Stackr
        $stackr->delete();

        return $this->all( $cnid );
	}

	public function changeTitle( $contextName, $eid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $eid ) || empty( $title ) )
			return;

		$stackr = Auth::user()->stackr( $eid )->first();
		$stackr->title = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeListTitle( $contextName, $eid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $eid ) || empty( $title ) )
			return;

		$stackr = Auth::user()->stackr( $eid )->first();
		$stackr->listTitle = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}	

	public function changePinStatus( $contextName, $eid )
	{
		$pinned = Input::get( 'fv', 0 );

		$stackr = Auth::user()->stackr( $eid )->first();
		$stackr->favored = $pinned;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeTags( $contextName, $eid )
	{
		$tags = Input::get( 'ts' );

		if ( empty( $tags ) )
			return;

		$stackr = Auth::user()->stackr( $eid )->first();
		$stackr->tags = $tags;
		$stackr->save();

		// the reload is done by ajax.success()
	}

}