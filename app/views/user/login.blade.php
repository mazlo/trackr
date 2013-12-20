@extends ( 'layout' )

@section( 'beforeContent' )

    <h3>Sign In</h3>

@stop

@section( 'content' )

    <h4 class='normal'>Please sign in to gain access. Have you already <a class='dotted' href='{{ URL::route("users/register") }}'>registered</a>?</h4>

    @if( $error = $errors->first( 'password' ) )
        <div class='credentials_error'>
            {{ $error }}
        </div>
    @elseif ( Session::has( 'registration_successfull' ) )
        <h4 class='message_success'>{{ Session::get( 'registration_successfull' ) }}</h4>
    @endif

    <form method='POST' action='{{ url() }}/' accept-charset='UTF-8' autocomplete='off' class='login'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4>Username</h4>
        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield form'>
        
        <h4>Password</h4>
        <input placeholder='●●●●●●●●' name='password' type='password' value='' id='password' class='textfield form'>

        <input type='submit' value='sign in' id='login_button' class='button' style='display: block; margin: 23px 0 0'>

    </form>

@stop
