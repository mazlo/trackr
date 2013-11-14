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
		<div id="header" style="height: 250px;">
			&nbsp;
		</div>
		
		<div id="content" style="width: 500; margin: auto">
			
			<h2>Please log in</h2>
			
			<span class="credentials_error"></span>
			<h4 class="normal">Username</h4>
			<input type="text" value="" id="username" class="textfield" />

			<h4 class="normal">Password</h4>
			<input type="text" value="" id="password" class="textfield" />
			<input type="button" id="login_button" class="login_button" value="Do it" />
		</div>
	</body>

<script type="text/javascript">

	$jQ( '#login_button' ).on( 'click', function()
	{
		var username = $jQ( '#username' ).val();
		var password = $jQ( '#password' ).val();

		$jQ.ajax( {
			url: "checkLogin.php",
			type: "get",
			data: { usr: username, pwd: password },

			success: function( data ) 
			{
				if ( data == "true" ) 
				{
					$jQ( '#content' ).effect( 'fade', 250, function()
					{
						document.location = "index.php";
					});
				}
				else
					$jQ( '.credentials_error' ).html( 'Error. Please check your credentials.' );
			}
		});
	});

</script>

</html>