@extends ( 'layout' )

@section( 'beforeContent' )

    <h3>Sign In</h3>

@stop

@section( 'content' )

    <p>Please sign in to gain access. Have you already <a class='dotted' href='{{ URL::route("users/register") }}'>registered</a>?</p>

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

        <p>
            MindStackr helps you organize your minds in terms of stacks, which actually is a list of items of your interest.
            Each item in the list we call a Stack, which usuablly covers a specific topic and it consists of no more, no less 
            a title and a description.
        </p>
        <p>
            The fundamental idea behind a Stack is that you can comment on it and that way track a history of thoughts 
            concerning your topic, just like you would manage your own blog.
        </p>
        <p>
            You can group several Stacks of the same topic, that's what is called a Context.
        </p>

        <h3>MindStackr is laid-out with maximum usability in mind.</h3>

        <div style='text-align: center'>
            <ul style='overflow: hidden; list-style-type: none; padding: 8px 0 0 108px;'>
                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Change the title of a Stackr or the Comments section and confirm by hitting enter.
                </li>

                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Organize the order of Comments by dragging.
                </li>

                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Delete some Comments if you don't like them, or even the complete Stack right away.
                </li>

                <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                    Convert a Comment into a Stack or even a Stack into a Context.
                </li>
            </ul>
        </div>

        <div style='clear: both'><img src='{{ url("resources/mindstackr_screenshot.png") }}' /></div>

        <ul style='overflow: hidden; list-style-type: none; padding: 8px 0 0;'>
            <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                Assign meaningful tags to your Stack, so you can filter and find the quickly.
            </li>

            <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                If you feel a Stack is important for you, pin it, so it will be shown always at the top.
            </li>

            <li style='float: left; background: #fcfcfc; border: 1px #bbb solid; width: 140px; height: 105px; padding: 13px; margin: 0 13px;'>
                Use the search field to find titles, descriptions and Comments.
            </li>
        </ul>

    </div>

@stop
