<?php

class StackrController extends BaseController {

	public function add()
	{

	}

	public function getAll()
	{
		$stackrs = Stackr::all();

		return View::make( 'stackr' )->with( 'stackrs', $stackrs );
	}

}