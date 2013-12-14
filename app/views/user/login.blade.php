@extends ( 'layout' )

@section( 'beforeContent' )

    <h3>Please log in</h3>

@stop

@section( 'content' )

    @if( $error = $errors->first( 'password' ) )
        <div class='credentials_error'>
            {{ $error }}
        </div>
    @elseif ( Session::has( 'registration_successfull' ) )
        <h4 class='message_success'>{{ Session::get( 'registration_successfull' ) }}</h4>
    @endif

    <form method='POST' action='{{ url() }}/' accept-charset='UTF-8' autocomplete='off'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4 class='normal'>Username</h4>
        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield' style='width: 300px'>
        
        <h4 class='normal'>Password</h4>
        <input placeholder='●●●●●●●●' name='password' type='password' value='' id='password' class='textfield' style='width: 300px'>

        <input type='submit' value='login' id='login_button' class='button' style='display: block; margin: 23px 0 0'>

    </form>

@stop
