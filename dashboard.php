<?php
	//Include all helper functions
	include_once( 'lib/user-functions.php' );
	//Start the session to be able to read back the stored variables
	session_start();
	//Read the variables from session storage
	$tmpUsername = $_SESSION['username'];
	$tmpPassword = $_SESSION['md5pass'];
	//Is the user not logged in and do we have invalid credentials?
	if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) or ($tmpUsername=="") or $tmpPassword=="") {
		//YES : Go back to the login form
		header("Location: login.php");
		//Stop script (not neccessary but recommended)
		exit();
	}
	//Declare a new connection to the DB
	$myDB = new Database( 'db/mybrary.db' );
//HTML code...
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $tmpUsername;?>'s Dashboard mybrary Version <?php echo MYBRARY_VERSION;?></title>
		<!-- CSS FILES -->
		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.5/dist/css/uikit.min.css" />
		<!-- CUSTOM CSS -->
		<link rel="stylesheet" type="text/css" href="css/dashboard.css">

	</head>

<!-- * * * * * * * * * * * BODY * * * * * * * * * * -->

	<body onload="PopulatePage()">
<!-- HIDDEN FIELDS -->
		<input type="hidden" id="tag-filter" value="">
		<input type="hidden" id="type-filter" value="">
<!-- /HIDDEN FIELDS -->
<!-- HEADER -->
		<header id="top-head" class="uk-position-fixed">
			<div class="uk-container uk-container-expand uk-background-primary">
				<nav id="search-bar" class="uk-navbar uk-light uk-padding-small" data-uk-navbar="mode:click; duration: 250">
<!--
 .d8888b.  8888888888        d8888 8888888b.   .d8888b.  888    888 888888b.         d8888 8888888b.
d88P  Y88b 888              d88888 888   Y88b d88P  Y88b 888    888 888  "88b       d88888 888   Y88b
Y88b.      888             d88P888 888    888 888    888 888    888 888  .88P      d88P888 888    888
 "Y888b.   8888888        d88P 888 888   d88P 888        8888888888 8888888K.     d88P 888 888   d88P
    "Y88b. 888           d88P  888 8888888P"  888        888    888 888  "Y88b   d88P  888 8888888P"
      "888 888          d88P   888 888 T88b   888    888 888    888 888    888  d88P   888 888 T88b
Y88b  d88P 888         d8888888888 888  T88b  Y88b  d88P 888    888 888   d88P d8888888888 888  T88b
 "Y8888P"  8888888888 d88P     888 888   T88b  "Y8888P"  888    888 8888888P" d88P     888 888   T88b
-->
				</nav>
			</div>
		</header>
<!--/HEADER-->


<!-- LEFT BAR -->
		<aside id="left-col" class="uk-light uk-visible@m">
			<div class="left-logo uk-flex uk-flex-middle">
				<img class="custom-logo" src="img/logo-dashboard.svg" width="200px" alt="">
			</div>
			<div class="left-content-box  content-box-dark">
				<img src="img/avatars/<?php echo $myDB->getAvatar( $_SESSION['username'] ); ?>" alt="" class="uk-border-circle profile-img">
				<h4 class="uk-text-center uk-margin-remove-vertical text-light">
<?php
					echo $myDB->getFullName( $_SESSION['username'] );
?>
				</h4>

				<div class="uk-position-relative uk-text-center uk-display-block">
				    <a href="#" class="uk-text-small uk-text-muted uk-display-block uk-text-center" data-uk-icon="icon: triangle-down; ratio: 0.7">
<?php
							echo $myDB->getRoleName( $_SESSION['username'] );
?>
						</a>
				    <!-- user dropdown -->
						<?php insertUserMenu( $myDB->getRole( $tmpUsername ), $tmpUsername );?>
				    <!-- /user dropdown -->
				</div>
			</div>

			<div class="left-nav-wrap">
				<ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
					<li class="uk-nav-header">Filters</li>
					<li class="uk-parent"><a href="#"><span data-uk-icon="icon: tag" class="uk-margin-small-right"></span>Tags</a>
						<ul id="side-tags" class="uk-nav-sub">
<!--
.d8888b.  8888888 8888888b.  8888888888 88888888888     d8888  .d8888b.   .d8888b.
d88P  Y88b  888   888  "Y88b 888            888        d88888 d88P  Y88b d88P  Y88b
Y88b.       888   888    888 888            888       d88P888 888    888 Y88b.
"Y888b.     888   888    888 8888888        888      d88P 888 888         "Y888b.
	 "Y88b.   888   888    888 888            888     d88P  888 888  88888     "Y88b.
		 "888   888   888    888 888            888    d88P   888 888    888       "888
Y88b  d88P  888   888  .d88P 888            888   d8888888888 Y88b  d88P Y88b  d88P
"Y8888P"  8888888 8888888P"  8888888888     888  d88P     888  "Y8888P88  "Y8888P"
-->
						</ul>


					</li>
					<li class="uk-parent">
						<a href="#"><span data-uk-icon="icon: thumbnails" class="uk-margin-small-right"></span>Types</a>
						<ul class="uk-nav-sub">
							<li><a onclick="RegisterTypeSearch('pdf')">PDF</a></li>
							<li><a onclick="RegisterTypeSearch('epub')">ePUB</a></li>
							<li><a onclick="RegisterTypeSearch('txt')">Plain Text</a></li>
							<li><a onclick="RegisterTypeSearch('md')">Markdown</a></li>
						</ul>
					</li>
					<li><a onclick="ResetFilters()"><span data-uk-icon="icon: refresh" class="uk-margin-small-right"></span>Reset Filters</a></li>
				</ul>


				<div id="side-library" class="left-content-box uk-margin-top">

<!--
 .d8888b. 8888888 8888888b.  8888888888 888      8888888 888888b.   8888888b.         d8888 8888888b. Y88b   d88P
d88P  Y88b  888   888  "Y88b 888        888        888   888  "88b  888   Y88b       d88888 888   Y88b Y88b d88P
Y88b.       888   888    888 888        888        888   888  .88P  888    888      d88P888 888    888  Y88o88P
 "Y888b.    888   888    888 8888888    888        888   8888888K.  888   d88P     d88P 888 888   d88P   Y888P
    "Y88b.  888   888    888 888        888        888   888  "Y88b 8888888P"     d88P  888 8888888P"     888
		  "888  888   888    888 888        888        888   888    888 888 T88b     d88P   888 888 T88b      888
Y88b  d88P  888   888  .d88P 888        888        888   888   d88P 888  T88b   d8888888888 888  T88b     888
 "Y8888P" 8888888 8888888P"  8888888888 88888888 8888888 8888888P"  888   T88b d88P     888 888   T88b    888
-->

				</div>
				<div class="uk-text-center uk-text-light" style="font-size: 8px;">
					mybrary engine <?php echo MYBRARY_VERSION;?>
				</div>
			</div>
		</aside>
<!-- /LEFT BAR -->


<!-- CONTENT -->
		<div id="content" data-uk-height-viewport="expand: true">
			<div class="uk-container uk-container-expand">
				<div id="info-table" class="uk-grid uk-grid-divider uk-grid-medium uk-child-width-1-3" data-uk-grid>
<!--
8888888 888b    888 8888888888 .d88888b. 88888888888     d8888 888888b.   888      8888888888
  888   8888b   888 888       d88P" "Y88b    888        d88888 888  "88b  888      888
  888   88888b  888 888       888     888    888       d88P888 888  .88P  888      888
  888   888Y88b 888 8888888   888     888    888      d88P 888 8888888K.  888      8888888
  888   888 Y88b888 888       888     888    888     d88P  888 888  "Y88b 888      888
  888   888  Y88888 888       888     888    888    d88P   888 888    888 888      888
  888   888   Y8888 888       Y88b. .d88P    888   d8888888888 888   d88P 888      888
8888888 888    Y888 888        "Y88888P"     888  d88P     888 8888888P"  88888888 8888888888
-->
				</div>
				<hr>
				<div class="uk-grid uk-grid-medium" data-uk-grid uk-sortable="handle: .sortable-icon">
					<div id="book-list" class="uk-child-width-1-1@xs uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
<!--
888888b.    .d88888b.   .d88888b.  888    d8P  888      8888888 .d8888b. 88888888888
888  "88b  d88P" "Y88b d88P" "Y88b 888   d8P   888        888  d88P  Y88b    888
888  .88P  888     888 888     888 888  d8P    888        888  Y88b.         888
8888888K.  888     888 888     888 888d88K     888        888   "Y888b.      888
888  "Y88b 888     888 888     888 8888888b    888        888      "Y88b.    888
888    888 888     888 888     888 888  Y88b   888        888        "888    888
888   d88P Y88b. .d88P Y88b. .d88P 888   Y88b  888        888  Y88b  d88P    888
8888888P"   "Y88888P"   "Y88888P"  888    Y88b 88888888 8888888 "Y8888P"     888
-->
					</div>
				</div>
				<footer class="uk-section uk-section-small uk-text-center">
					<hr>
					<p class="uk-text-small uk-text-center">
						© 2020 by D.Sánchez - <a href="https://www.dsanchez.net/">www.dsanchez.net</a> | Published under the <a href="https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12" title="European General Public License" target="_blank" data-uk-tooltip>EUPL</a>
					</p>
				</footer>
			</div>
		</div>
<!-- /CONTENT -->


<!-- MODAL DIALOG SKELETON -->
		<div id="modal-dash" uk-modal>
		    <div id="modal-body" class="uk-modal-dialog uk-modal-body">
<!--
888b     d888  .d88888b.  8888888b.        d8888 888      888888b.    .d88888b.  8888888b. Y88b   d88P
8888b   d8888 d88P" "Y88b 888  "Y88b      d88888 888      888  "88b  d88P" "Y88b 888  "Y88b Y88b d88P
88888b.d88888 888     888 888    888     d88P888 888      888  .88P  888     888 888    888  Y88o88P
888Y88888P888 888     888 888    888    d88P 888 888      8888888K.  888     888 888    888   Y888P
888 Y888P 888 888     888 888    888   d88P  888 888      888  "Y88b 888     888 888    888    888
888  Y8P  888 888     888 888    888  d88P   888 888      888    888 888     888 888    888    888
888   "   888 Y88b. .d88P 888  .d88P d8888888888 888      888   d88P Y88b. .d88P 888  .d88P    888
888       888  "Y88888P"  8888888P" d88P     888 88888888 8888888P"   "Y88888P"  8888888P"     888
-->
		    </div>
		</div>
<!-- /MODAL DIALOG SKELETON -->

<!-- UIKIT JS FILES -->
		<script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit-icons.min.js"></script>
<!-- CUSTOM JS FILES -->
		<script src="js/mybrary.js"></script>
<!-- /CUSTOM JS FILES -->

	</body>
</html>
<!-- Ansi Regular and  Colossal -->
