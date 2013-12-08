@extends ( 'layout' )

@section( 'content' )

    <h3>Please log in</h3>

    @if( $error = $errors->first( 'password' ) )
        <div class='credentials_error'>
            {{ $error }}
        </div>
    @endif

    <form method='POST' action='http://localhost:8888/mindstackr/public/' accept-charset='UTF-8' autocomplete='off'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4 class='normal'>Username</h4>
        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield_smaller'>
        
        <h4 class='normal'>Password</h4>
        <input placeholder='●●●●●●●●●●' name='password' type='password' value='' id='password' class='textfield_smaller'>

        <input type='submit' value='login' id='login_button' class='button' style='display: block; margin: 23px 0 0'>

    </form>

@stop
