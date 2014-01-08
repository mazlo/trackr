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

@section( 'footer' )
    <div style='padding: 23px;'>

        <h3>What the heck is <span style='font-size: 23px'>M</span>ind<span style='font-size: 23px'>S</span>tackr?</h3>

        <p>MindStackr helps you organize your minds in terms of stacks, which basically is a list of items. 
            Each item in the list we call a Stack, which usuablly covers a specific topic and it consists of no more or less 
            a title and a description.
            The fundamental idea behind a Stack is that you can comment on it and that way track a history of thoughts 
            concerning your topic.
        </p>

        <h3>MindStackr is laid-out with maximum usability in mind.</h3>

        <div style=''>
            <ul style='overflow: auto; list-style-type: none; padding: 8px 0 0;'>
                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 145px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Change the title of a Stackr or the Comments section and confirm by clicking enter.
                </li>

                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 145px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Organize the order of Comments by dragging.
                </li>
            </ul>
        </div>

        <div style='clear: both'><img src='{{ url("resources/mindstackr_screenshot.png") }}' /></div>

    </div>

@stop
