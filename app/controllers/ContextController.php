<?php

class ContextController extends BaseController {

	public function showAll()
	{
		$contexts = Context::all();

		return View::make( 'contexts' )->with( 'contexts', $contexts );
	}

}