<?php

class ContextController extends BaseController {

	/*
		Loads all contexts for current user
	*/
	public function all()
	{
		$contexts = User::find( Auth::user()->id )->contexts()->get();

		return View::make( 'contexts' )->with( 'contexts', $contexts );
	}

}