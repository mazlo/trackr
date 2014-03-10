<?php

class StackrController extends BaseController {

	/**
	*	Get all Stackrs for User for the given Context
	*/
	public function index( $contextName )
	{
		$context = Auth::user()->context( $contextName )->first();

		// if ajax => return ajax view for all Stackrs
		if ( Request::ajax() )
		{
			$stackrs = Auth::user()->stackrs( $contextName )->orderBy( 'favored', 'desc' )->orderBy( 'created_at', 'desc' )->get();

			// prepare relations
			$stackrRelation = array();

			// run through all Stackrs and check if one relates to an other
			foreach ( $stackrs as $stackr ) 
			{
				if ( !isset( $stackr->linksTo ) )
					continue;

				// e.g. "relation-for-145" = $stackr#132
				$stackrRelation[ "for-" . $stackr->id ] = Auth::user()->stackr( $stackr->linksTo )->first();
			}

			return View::make( 'ajax.stackrs' )
				->with( 'stackrs', $stackrs )
				->with( 'stackrRelation', $stackrRelation );
		}

		if ( isset( $context ) )
		{
			// add all Contexts
			return View::make( 'stackrs' )
				->with( 'context', $context )
				->with( 'contexts', Auth::user()->contexts()->orderBy( 'position' )->get() );
		}
		else
			// TODO create view with error
			return View::make( 'stackrs' )->with( 'context', 'null' );
	}

	public function add( $contextName )
	{
		$context = Auth::user()->context( $contextName )->first();

		// TODO check if context exists

		if ( Input::has( 'tl' ) )
		{
			$stackr = new Stackr();

			// description
			if ( Input::has( 'ds' ) )
				$stackr->description = trim( Input::get( 'ds' ) );

			$stackr->title = trim( Input::get( 'tl' ) );
			$stackr->user()->associate( Auth::user() );
			$stackr->context()->associate( $context );
			$stackr->save();
		}

		return $this->index( $contextName );
	}

	public function show( $contextName, $sid )
	{
		$stackr = Auth::user()->stackr( $sid )->first();

		return View::make( 'stackr' )->with( 'stackr', $stackr );
	}

	public function delete( $contextName, $sid )
	{
		if ( !isset( $contextName ) || !isset( $sid ) )
			return;

		$stackr = Auth::user()->stackr( $sid )->first();

		// delete all related Comments
        foreach( $stackr->comments as $comment )
        {
            $comment->delete();
        }

        // delete the Stackr
        $stackr->delete();

        return $this->index( $contextName );
	}

	/**
	*	Update Stackr
	*/
	public function update( $contextName, $sid )
	{
		$stackr = Auth::user()->stackr( $sid )->first();

		// update Stackr title
		if ( Input::has( 'tl') )
			$stackr->title = Input::get( 'tl' );

		// update Stackr listTitle
		else if ( Input::has( 'ltl' ) )
			$stackr->listTitle = Input::get( 'ltl' );

		// update Stackr status favored 
		else if ( Input::has( 'fv' ) )
			$stackr->favored = Input::get( 'fv', 0 );

		// update Stackr tags
		else if ( Input::has( 'tg' ) )
		{
			// '-' means they are empty
			$tags = Input::get( 'tg' );
			if ( $tags == '-' )
				$tags = '';

			$stackr->tags = $tags;
		}

		// update link to other Stackr
		else if ( Input::has( 'lto' ) )
			$stackr->linksTo = Input::get( 'lto' );

		// update parent Context
		else if ( Input::has( 'cname' ) )
		{
			$context = Auth::user()->context( $contextName )->first();
			// assign
			$stackr->context()->associate( $context );
		}

		$stackr->save();
	}

	/**
	*	Email a Stackr
	*/
	public function email( $contextName, $sid )
	{
		// prepare objects
		$user = Auth::user();
		$stackr = $user->stackr( $sid )->first();

		// construct data to be passed to view
		$data = array( 'stackr' => $stackr );

		// send the email
		Mail::queue( 'emails.stackr', $data, function( $message ) use ( $user, $stackr )
        {
            $message->to( $user->email, $user->username );
            $message->subject( $stackr->title );
        });	
	}

}