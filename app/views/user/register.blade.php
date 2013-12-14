@extends( 'layout' )

@section( 'beforeContent' )

	<h3>Registration</h3>

@stop

@section( 'content' )

	<h4 class='normal'>Create a new user account here.</h4>
	<h4 class='normal'>All it takes is a username, an email, and a password. Then you can start right away!</h4>

	<form method='POST' action='{{ URL::route("users/register") }}' accept-charset='UTF-8' autocomplete='off' class='register'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4 class='normal'>Username</h4>
        @if( $errors->has( 'username' ) )
        	<span class='credentials_error'>{{ $errors->get( 'username' )[0] }}</span>
        @endif

        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield' style='width: 300px; margin: 3px 0' value='{{ Input::old( "username" ) }}'>
        
        <h4 class='normal'>E-Mail Address</h4>
        @if( $errors->has( 'email' ) )
        	<span class='credentials_error'>{{ $errors->get( 'email' )[0] }}</span>
        @endif

        <input placeholder='john.smith@email.com' name='email' type='text' id='email' class='textfield' style='width: 300px; margin: 3px 0' value='{{ Input::old( "email" ) }}'>

		<h4 class='normal'>Password</h4>
		@if( $errors->has( 'password' ) )
	    	<span class='credentials_error'>{{ $errors->get( 'password' )[0] }}</span>
        @endif

        <input placeholder='●●●●●●●●' name='password' type='password' value='' id='password' class='textfield' style='width: 300px; margin: 3px 0'>

        <h4 class='normal'>Confirm Password</h4>
        
        <input placeholder='●●●●●●●●' name='password_confirmation' type='password' value='' id='password_confirmation' class='textfield' style='width: 300px; margin: 3px 0'>
        <input type='submit' value='create account' id='login_button' class='button' style='display: block; width: auto; margin: 23px 0 0'>

    </form>

@stop