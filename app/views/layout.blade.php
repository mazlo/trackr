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
					<span id="searchResults" class="infotext"></span>
					<input type="text" id="search" class="textfield_smaller" style="width: 200px; margin-top: 6px; margin-right: 23px;" />
					<span><? if ( isset( $_SESSION[ 'username' ] ) ) echo 'username'; else echo 'username'; ?></span><button class='operatorButton' style="margin-left: 23px; color: lightgray">logout</button>
				</div>

				<div style="clear: both; height: 0"></div>
			</div>

			<!-- navigation contains tag list -->
			<div id="beforeContent">

				@yield( 'beforeContent' )

			</div>

			<!-- content contains list of entries -->
			<div id="content">

				<!-- div entry add: is hidden after page load -->
				<div id="div_entry_add" class="div_entry_add" style="display: none; margin: 8px 0;">

					<h4 class="entry_new_title">Title</h4>
					<input type="text" id="title" value="" class="textfield" />
					
					<h4 class="entry_new_description">Description</h4>
					<textarea id="description" class="textarea"></textarea>

					<div style="padding: 8px 0;">
						<input type="button" class="entry_add_button" value="Add" />
						<input type="button" class="entry_add_cancel" value="Cancel" />
					</div>

				</div>

				<!-- list of entries -->
				<div id="entries" style="margin-top: 8px;">
					@yield( 'stackrs' )
				</div>

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