<?php
  chdir('..');
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
  $tmpBookStore = 'data/books/';
  if (isset($_GET['id'])) { //Do we hace an ID?
    //YES
    switch ( $myDB->getBookType( $_GET['id'] ) ) {
      case "pdf":
        header("Location: pdf.html?file=../".$tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).".pdf" );
        //TODO : Insert pdf.js
        exit;
        break;
      case "epub":
          //TODO : Insert epub reader component.
        break;
      case "md":
        $tmpBookData = file_get_contents( $tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).'.md' );
        $tmpParse = new Parsedown();
        break;
      case "txt":
        $tmpBookData = file_get_contents( $tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).'.txt' );
        $tmpParse = new FakeDown();
        break;

      default:
        echo "error. no valid filetype detected";
    }
  } else {
    echo "error. no file provided";
  }

?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>mybrary Viewer</title>
		<!-- CSS FILES -->
		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.5/dist/css/uikit.min.css" />
		<!-- CUSTOM CSS -->
		<link rel="stylesheet" type="text/css" href="../css/viewer.css">
	</head>
<body>
<?php

  echo $tmpParse->text( $tmpBookData );
?>
</body>
</html>
