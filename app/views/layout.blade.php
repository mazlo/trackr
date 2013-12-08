<html>
<head>
	<!-- external -->
	<!-- simplifies javascript programming -->
	<link rel="stylesheet" type="text/css" href="resources/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="resources/main.css"></link>

	<script src="resources/prototype.js"></script>
	<script src="resources/jquery-1.8.2.js"></script>
	<script src="resources/jquery-ui-1.9.2.custom.js"></script>
	<script src="resources/missy.js"></script>

	<script type="text/javascript">
		<!-- this is to prevent conflicts with prototype and jquerytools -->
		$jQ = jQuery.noConflict();
	</script>

</head>
	<body>
		<div id="container">

			<!-- header contains logo and login -->
			<div id="header">
				
				<div style="float: left;">
					<h2 style="margin: 0"><span style="font-size: 36px">M</span>ind<span style="font-size: 36px">S</span>tackr</h2>
				</div>

				<div style="float: right; text-align: right">
	 				@if ( Auth::check() )
	 					<!-- print search field -->
		 				<span id="searchResults" class="infotext"></span>
						<input type="text" id="search" class="textfield_smaller" style="width: 200px; margin-top: 6px; margin-right: 23px;" />

						<!-- print user specific information -->
	 					<span>{{ Auth::user()->username }}</span>
						<a href='{{ URL::route( 'user/logout' ) }}'>
							<button class='operatorButton' style="margin-left: 23px; color: lightgray">logout</button>
						</a>
					@endif
				</div>

				<div style="clear: both; height: 0"></div>
			</div>

			<!-- navigation contains tag list -->
			<div id="beforeContent">

				@yield( 'beforeContent' )

			</div>

			<!-- content contains list of entries -->
			<div id="content">

				@yield( 'content' )

			</div>

			<div id="footer" style="margin-top: 48px">
				
				@yield( 'footer' )

			</div>
		</div>
	</body>

<script type='text/javascript'>

	// on document ready load all entries
	$jQ( function()
	{
		getDistinctEntriesTagList();
	});

</script>