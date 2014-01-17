@extends( 'layout' )

@section( 'beforeContent' )

	<h3>Give us Feedback</h3>

@stop

@section( 'content' )

	@if ( isset( $submitted ) && $submitted )
		<h4 style='color: #ba0000'>Thank you for your feedback! We're doing our best.</h4>
		<h4>You might want to say something else?</h4>
	@else
		<h4>Thank you for using MindStackr.com. We appreciate your feedback!</h4>
	@endif

	<form method='post' action='{{ url("feedback") }}' accept-charset='UTF-8' autocomplete='off' class='form-default form-feedback' style='width: 460px'>

		<h3>Feedback Form</h3>

		<h4>What kind of feedback do you want to give?</h4>

		<select name='feedbackType'>
			<option>I just wanted to say that I like it</option>
			<option>Sorry, not my thing</option>
		</select>

		<h4>It there a specific reason?</h4>

		<select name='reason'>
				<option>Just so</option>
				<option>Yeah, but I'll not tell ya!</option>
		</select>

		<h4>What else do you want to say or ask?</h4>

        <textarea class='textarea form' name='comment' placeholder='Your opinion (optional)'></textarea>
        
        <h4>Please send an answer to (or a comment on) my feedback to</h4>

		<input placeholder='john.smith@email.com' name='emailTo' type='text' id='emailTo' class='textfield form'>

        <input type='submit' value='send feedback' id='login_button' class='button login-button' style='width: 110px;'>

	</form>

@stop

@section( 'terms' )
	@include( 'terms-section' )
@stop