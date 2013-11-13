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
			<h4 class="normal">Username</h4>
			<input type="text" value="" name="username" class="textfield" />

			<h4 class="normal">Password</h4>
			<input type="text" value="" name="password" class="textfield" />
			<input type="button" id="login_button" class="login_button" value="Do it" />
		</div>
	</body>

<script type="text/javascript">

	$jQ( '#login_button' ).click( function()
	{
		$jQ( '#content' ).effect( 'fade', 250, function() 
		{
			document.location = "index.php";
		} );
	});

</script>

</html>