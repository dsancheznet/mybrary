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
	$myDB = new Database();
  //Declare the book path
  $tmpBookStore = MYBRARY_MEDIA_PATH.'books/';
  if (isset($_GET['id'])) { //Do we hace an ID?
    //YES
    switch ( $myDB->getBookType( $_GET['id'] ) ) {
      case "pdf":
        if ( MYBRARY_HIDE_BOOKS ) {
          header("Location: pdf.html?file=getbook.php?id%3D".$_GET['id'] );
        } else {
          header("Location: pdf.html?file=../".$tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).".pdf");
        }
        exit;
        break;
      case "epub":
        // old version: header("Location: epub.html?book=".$myDB->getBookUUID( $_GET['id'] ).".".$myDB->getBookType($_GET['id']) );
        if ( MYBRARY_HIDE_BOOKS ) {
          header( "Location: epub.html?book=getbook.php?id%3D".$_GET['id'] );
        } else {
          header( "Location: epub.html?book=../".$tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).".epub" );
        }
        exit;
        break;
      case "md":
        $tmpBookData = file_get_contents( $tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).".".$myDB->getBookType($_GET['id']) );
        $tmpParse = new Parsedown();
        break;
      case "txt":
        $tmpBookData = file_get_contents( $tmpBookStore.$myDB->getBookUUID( $_GET['id'] ).".".$myDB->getBookType($_GET['id']) );
        $tmpParse = new FakeDown();
        break;
      default:
        echo "error. no valid filetype detected";
    }
  } else {
    echo "error. no file provided";
  }

// HTML code to generate md and txt files...

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
