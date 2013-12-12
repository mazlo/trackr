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

		// the reload is done by ajax.success()
	}

	public function changeTitle()
	{
		$eid = Input::get( 'eid' );
		$title = Input::get( 'tl' );

		if ( empty( $eid ) || empty( $title ) )
			return;

		$stackr = Stackr::find( $eid );
		$stackr->title = $title;
		$stackr->save();
	}

}