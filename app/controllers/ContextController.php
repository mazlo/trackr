<?php

class ContextController extends BaseController {

	public function showAll()
	{
		return View::make( 'contexts' );
	}

}