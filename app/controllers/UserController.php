<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    public function registerAction()
    {
        $data = array();

        // check if data was postet
        if ( Input::server( 'REQUEST_METHOD') == 'POST' )
        {
            // rules for input fields
            $rules = array(
                'username' => 'required|unique:users',
                'email' => 'required|email|min:8|unique:users',
                'password' => 'required|min:6|confirmed'
            );
            
            // messages for validation errors
            $messages = array(
                'required' => 'You forgot to fill this in!',
                'min' => 'Please give at least 6 characters!',
                'email.unique' => 'This email address has already been registered!',
                'password.confirmed' => 'The passwords given do not match!'
            );

            $validator = Validator::make( Input::all(), $rules, $messages );

            if ( $validator->fails() )
            {
                return Redirect::route( 'users/register' )->withErrors( $validator )->withInput( Input::all() );
            }

            $user = new User();
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );
            $user->password = Hash::make( Input::get( 'password' ) );
            $user->save();

            return Redirect::route( 'user/login' )->with( 'registration_successfull', 'Yeah! Thank\'s for registering! You can now sign in.' );
        }

        // someone wants to register
        return View::make( 'user.register' );
    }

	public function loginAction()
    {
    	$data = array();

    	// check if user is logged in
    	if ( Auth::check() )
    	{
    		return Redirect::route( 'landingPage' );
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
                    return Redirect::route( 'landingPage' );
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