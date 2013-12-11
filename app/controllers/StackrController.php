<?php

class StackrController extends BaseController {

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

	public function getAll()
	{
		$stackrs = Stackr::all();

		return View::make( 'stackr' )->with( 'stackrs', $stackrs );
	}

}