<?php

class StackrController extends BaseController {

	/**
	*	Create the view and pass the given Context
	*/
	public function view( $contextName )
	{
		$context = Auth::user()->contexts()->where( 'name', $contextName )->first();

		if ( isset( $context ) )
			return View::make( 'stackrs' )->with( 'cnid', $context->id );
		else
			// TODO create view with error
			return View::make( 'stackrs' )->with( 'cnid', 'null' );
	}

	/**
	*	Get all Stackrs for User for the given Context
	*/
	public function all( $contextName )
	{
		$stackrs = Auth::user()->stackrs( $contextName )->orderBy( 'favored', 'desc' )->orderBy( 'id', 'desc' )->get();

		return View::make( 'ajax.stackrs' )->with( 'stackrs', $stackrs );
	}

	public function add()
	{
		$title = Input::get( 'tl' );
		$desc = Input::get( 'ds' );

		if ( empty( $title ) || empty( $desc ))
			return;

		$stackr = new Stackr();
		$stackr->title = $title;
		$stackr->description = $desc;
		$stackr->user()->associate( Auth::user() );
		$stackr->save();

		return $this->all();
	}

	public function details( $eid )
	{
		$stackr = Stackr::find( $eid );

		return View::make( 'stackr' )->with( 'stackr', $stackr );
	}

	public function delete( $eid )
	{
		if ( empty( $eid ) )
			return;

		$stackr = Stackr::find( $eid );

		// delete all related Comments
        foreach( $stackr->comments as $comment )
        {
            $comment->delete();
        }

        // delete the Stackr
        $stackr->delete();

        return $this->all();
	}

	public function changeTitle( $eid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $eid ) || empty( $title ) )
			return;

		$stackr = Stackr::find( $eid );
		$stackr->title = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeListTitle( $eid )
	{
		$title = Input::get( 'tl' );

		if ( empty( $eid ) || empty( $title ) )
			return;

		$stackr = Stackr::find( $eid );
		$stackr->listTitle = $title;
		$stackr->save();

		// the reload is done by ajax.success()
	}	

	public function changePinStatus( $eid )
	{
		$pinned = Input::get( 'fv', 0 );

		$stackr = Stackr::find( $eid );
		$stackr->favored = $pinned;
		$stackr->save();

		// the reload is done by ajax.success()
	}

	public function changeTags( $eid )
	{
		$tags = Input::get( 'ts' );

		if ( empty( $tags ) )
			return;

		$stackr = Stackr::find( $eid );
		$stackr->tags = $tags;
		$stackr->save();

		// the reload is done by ajax.success()
	}

}