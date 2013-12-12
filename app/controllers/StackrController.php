<?php

class StackrController extends BaseController {

	public function show()
	{
		return View::make( 'stackr' );
	}

	public function all()
	{
		$stackrs = Stackr::all();

		return View::make( 'ajax.stackr' )->with( 'stackrs', $stackrs );
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
		$stackr->save();

		return View::make( 'ajax.stackr' )->with( 'stackrs', Stackr::all() );
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

        return View::make( 'ajax.stackr' )->with( 'stackrs', Stackr::all() );
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

}