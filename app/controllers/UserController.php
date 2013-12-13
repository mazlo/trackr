<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller
{
	public function loginAction()
    {
    	$data = array();

    	// check if user is logged in
    	if ( Auth::check() )
    	{
    		return Redirect::route( 'showStackrs' );
    	}

    	// check if data was postet
    	if ( Input::server( 'REQUEST_METHOD') == 'POST' )
        {
            $validator = Validator::make( Input::all(), array(
                'username' => 'required',
                'password' => 'required'
            ));

            if ( $validator->passes() )
            {
                $credentials = array(
                    'username' => Input::get( 'username' ),
                    'password' => Input::get( 'password' )
                );

                // successful login redirects
                if ( Auth::attempt( $credentials ) )
                {
                    return Redirect::route( 'showStackrs' );
                }
            }

            // validation does not pass or wrong credentials
        	$data[ 'errors' ] = new MessageBag( array(
        		'password' => 'Username and/or password invalid.'
            ));

            $data[ 'username' ] = Input::get( 'username' );

			return Redirect::route( 'user/login' )->with( $data );
        }

        return View::make( 'user/login', $data )->withInput( $data );
    }

    public function logoutAction()
	{
	    Auth::logout();
	    return Redirect::route( 'user/login' );
	}
}