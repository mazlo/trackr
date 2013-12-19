<?php

class ContextController extends BaseController {

	public function view()
	{
		return View::make( 'contexts' );
	}

	/*
		Loads all contexts for current user
	*/
	public function all()
	{
		$contexts = User::find( Auth::user()->id )->contexts()->get();

		return View::make( 'ajax.contexts' )->with( 'contexts', $contexts );
	}

}