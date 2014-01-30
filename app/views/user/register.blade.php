@extends( 'layout' )

@section( 'beforeContent' )

	<h3>Registration</h3>

@stop

@section( 'content' )

	<h4 class='normal'>Create a new user account here.</h4>
	<h4 class='normal'>All it takes is a username, an email, and a password. Then you can <a class='dotted' href='{{ URL::route( "user/login" ) }}'>start right away</a>!</h4>

	<form method='POST' action='{{ URL::route("users/register") }}' accept-charset='UTF-8' autocomplete='off' class='form-default form-register'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4>Username</h4>
        @if( $errors->has( 'username' ) )
        	<span class='credentials-error'>{{ $errors->get( 'username' )[0] }}</span>
        @endif

        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield form' value='{{ Input::old( "username" ) }}'>
        
        <h4>E-Mail Address</h4>
        @if( $errors->has( 'email' ) )
        	<span class='credentials-error'>{{ $errors->get( 'email' )[0] }}</span>
        @endif

        <input placeholder='john.smith@email.com' name='email' type='text' id='email' class='textfield form' value='{{ Input::old( "email" ) }}'>

		<h4>Password</h4>
		@if( $errors->has( 'password' ) )
	    	<span class='credentials-error'>{{ $errors->get( 'password' )[0] }}</span>
        @endif

        <input placeholder='●●●●●●●●' name='password' type='password' value='' id='password' class='textfield form' >

        <h4>Confirm Password</h4>
        
        <input placeholder='●●●●●●●●' name='password_confirmation' type='password' value='' id='password_confirmation' class='textfield form'>

        <p style='font-size: 14px'>
            @if( $errors->has( 'terms' ) )
                <span class='credentials-error'>{{ $errors->get( 'terms' )[0] }}</span>
            @endif

            <input type='checkbox' name='terms' value='checked'>I accept the <a class='dotted' href='{{ url("terms-and-conditions") }}'>terms and conditions</a> of MindStackr.com.
        </p>

        <input type='submit' value='create account' id='login_button' class='button login-button element-shadow' style='width: 110px;'>

    </form>

@stop

@section( 'footer' )
    @include( 'terms' )
@stop
