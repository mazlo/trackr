<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	*	Returns the view for terms and conditions
	*/
	public function terms()
    {
        return View::make( 'terms-and-conditions' );
    }

}