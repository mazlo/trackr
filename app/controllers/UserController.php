<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller
{
	public function loginAction()
    {
    	$data = [];

    	// check if user is logged in
    	if ( Auth::check() )
    	{
    		return Redirect::to( 'stackr' );
    	}

    	// check if data was postet
    	if ( Input::server( 'REQUEST_METHOD') == 'POST' )
        {
            $validator = Validator::make( Input::all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

            if ( $validator->passes() )
            {
                $credentials = [
                    'username' => Input::get( 'username' ),
                    'password' => Input::get( 'password' )
                ];

                // successful login redirects
                if ( Auth::attempt( $credentials ) )
                {
                    return Redirect::to( 'stackr' );
                }
            }

            // validation does not pass or wrong credentials
        	$data[ 'errors' ] = new MessageBag( 
        	[	
        		'password' => [ 'Username and/or password invalid.' ]
            ]);

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