<?php

class StackrController extends BaseController {

	public function show()
	{
		return View::make( 'stackrs' );
	}

	/*
		Just create the view and pass the current context id
	*/
	public function showAll( $cnid )
	{
		// TODO check here if cnid exist and redirect if not
		
		return View::make( 'stackrs' )->with( 'cnid', $cnid );
	}

	public function all( $cnid )
	{
		$stackrs = Auth::user()->stackrs( $cnid )->orderBy( 'favored', 'desc' )->orderBy( 'id', 'desc' )->get();

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