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
		$feedback = new Feedback();

		$feedback->feedbackType = Input::get( 'feedbackType' );
		$feedback->reason = Input::get( 'reason' );

		$comment = Input::get( 'comment' );
		if ( !empty( $comment ) )
			$feedback->comment = $comment;

		$emailTo = Input::get( 'emailTo' );
		if ( !empty( $emailTo ) )
			$feedback->emailTo = $emailTo;

		$feedback->save();

		$data = array( 'feedback' => $feedback );

		Mail::send( 'emails.feedback', $data, function( $message )
		{
		    $message->to( 'matthaeus.zloch@gmail.com', 'Me' );
		    $message->subject( 'New Feedback' );
		});

		return View::make( 'feedback' )->with( 'submitted', true );
	}
}