<?php

class FeedbackController extends BaseController
{

	/**
	*	Returns the view 
	*/
	public function index()
	{
		return View::make( 'feedback' );
	}

	/**
	*	Adds a new Feedback
	*/
	public function add()
	{

	}
}