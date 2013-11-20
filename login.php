<?php

	session_start();

	// submit on form via POST
	if( $_SERVER[ 'REQUEST_METHOD' ] == "POST" )
	{
		// username and password sent from form 
		$username = addslashes( $_POST[ 'username' ] ); 
		$password = addslashes( $_POST[ 'password' ] ); 

		// connect
		$mysqli = new mysqli( "localhost", "root", "root", "shorter");

		if ( $mysqli->connect_errno ) 
		{
		    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$crypted = crypt( $password, '$2a$klo)e8-9129.c2)=1das?1$' );

		// query database for username and password
    	$result = $mysqli->query( "SELECT id, auth_string FROM user WHERE username = '$username' and password = '$crypted'" );
		$row = $result->fetch_assoc();
		$count = $result->num_rows;

		// if one entry exists
		if( $count == 1 )
		{
			// set session attributes and redirect
			$_SESSION[ 'username' ] = $username;
			$_SESSION[ 'auth_string' ] = $row['auth_string'];

			header( 'location: index.php' );
		}
		else 
		{
			$error = "Your username or password is not invalid";
		}
	}
	// page load via GET
	else 
	{
		// check if session attributes exist and redirect
		if ( isset( $_SESSION[ 'username' ] ) )
		{
			if ( crypt( $_SESSION[ 'username' ], '$1tu8CWdqTf9.' ) == $_SESSION[ 'auth_string' ] )
				header( 'location: index.php' );
		}
	}
?>

<html>
<head>
	<head>
	<!-- external -->
	<!-- simplifies javascript programming -->
	<link rel="stylesheet" type="text/css" href="resources/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="resources/main.css"></link>

	<script src="resources/prototype.js"></script>
	<script src="resources/jquery-1.8.2.js"></script>
	<script src="resources/jquery-ui-1.9.2.custom.js"></script>

	<script type="text/javascript">
		<!-- this is to prevent conflicts with prototype and jquerytools -->
		$jQ = jQuery.noConflict();
	</script>

</head>
</head>

	<body>
		<div id="header" style="width: 800px; margin: auto; padding: 13px 0;">
			<div style="height: 23px; text-align: right">&nbsp;</div>

			<h2>Trackr</h2>
		</div>
		
		<div id="content" style="width: 800px; margin: auto; padding-top: 120px;">
			
			<h3>Please log in</h3>
			
			<span class="credentials_error"></span>
			
			<form method="POST">
				<h4 class="normal">Username</h4>
				<input type="text" value="" id="username" name="username" class="textfield" />

				<h4 class="normal">Password</h4>
				<input type="password" value="" id="password" name="password" class="textfield" />
				<input type="submit" id="login_button" class="login_button" value="Do it" />
			</form>
		</div>
	</body>

</html>