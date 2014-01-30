@extends ( 'layout' )

@section( 'beforeContent' )

    <h3>Sign in</h3>

@stop

@section( 'content' )

    <p>Please sign in to gain access. Have you already <a class='dotted' href='{{ URL::route("users/signup") }}'>signed up</a>?</p>

    @if( $error = $errors->first( 'password' ) )
        <div class='credentials-error'>
            {{ $error }}
        </div>
    @elseif ( Session::has( 'signup_successfull' ) )
        <h4 class='message_success'>{{ Session::get( 'signup_successfull' ) }}</h4>
    @endif

    <form method='POST' action='{{ url() }}/' accept-charset='UTF-8' autocomplete='off' class='form-default form-login'>

        <input name='_token' type='hidden' value='TbVUNXU82jmVLLrSGHT360dEYlhRmX5ca0E1iPxv'>

        <h4>Username</h4>
        <input placeholder='john.smith' name='username' type='text' id='username' class='textfield form'>
        
        <h4>Password</h4>
        <input placeholder='●●●●●●●●' name='password' type='password' value='' id='password' class='textfield form'>

        <input type='submit' value='sign in' id='login_button' class='button button-login element-shadow'>

    </form>

@stop

@section( 'footer' )
    <div style='padding: 0 23px'>

        <h3>What the heck is <span style='font-size: 23px'>M</span>ind<span style='font-size: 23px'>S</span>tackr?</h3>

        <p>
            MindStackr helps you organize your minds in terms of stacks, which actually is a list of items of your interest.
            Each item in the list we call a Stack, which usually covers a specific topic and it consists of no more, no less 
            a title and a description.
        </p>
        <p>
            The fundamental idea behind a Stack is that you can comment on it and that way track a history of thoughts 
            concerning your topic, just like you would manage a blog post of yours and would comment on that on your own.
        </p>
        <p>
            You can group several Stacks of the same topic, that's what is called a Context.
        </p>

        <h3>Usability in MindStackr</h3>

        <p>
            MindStackr is laid-out with maximum usability in mind: all changes on your Stacks should be just on click away. 
        </p>

        <ul class='list-box'>
            <li class='list-box-feature'>
                Click on the title, description or title of comment section of a MindStack to change it.
            </li>

            <li class='list-box-feature'>
                Organize the order and position of Comments inside a MindStack by dragging them.
            </li>

            <li class='list-box-feature'>
                Delete some Comments or even the complete MindStack if you don't like them.
            </li>

            <li class='list-box-feature'>
                Convert a Comment into a MindStack or even a MindStack into a Context.
            </li>
        </ul>

        <div><img src='{{ url("resources/mindstackr_screenshot.png") }}' /></div>

        <ul class='list-box'>
            <li class='list-box-feature'>
                Assign meaningful tags to your MindStack, so you can filter and find them quickly.
            </li>

            <li class='list-box-feature'>
                If you think one Stack is important for you, pin it, so it will be shown always at the top.
            </li>

            <li class='list-box-feature'>
                Use the search field at the top to find Stack titles, descriptions or Comments.
            </li>

            <li class='list-box-feature'>
                Confirm or abort your input in textfields by hitting enter or escape.
            </li>
        </ul>

    </div>

    @include( 'terms' )
@stop
