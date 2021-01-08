<?php
  include_once( 'user-functions.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  $myDB = new Database();
  
  $tmpUserRole = $myDB->getRole( $tmpUsername );
//Is the user logged in on do we have valid credentials?
if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
  //NO
  //Stop script (not neccessary but recommended)
  echo "Access Denied. <br />";
  echo "Unable to verify your session.";
  exit();
} else {
  if ( isset( $_GET['uuid'] ) ) { //Do we have an ID?
    //YES
    $tmpBookUUID = $_GET['uuid'];
    if ( $myDB->bookHasCover( $tmpBookUUID ) ) {
      header('Content-Type: image/jpeg');
      header("Pragma: no-cache");
      header("Expires: 0");
      echo $myDB->getBookCoverData( $tmpBookUUID );
    } else {
      header('Content-Type: image/svg+xml');
      header("Pragma: no-cache");
      header("Expires: 0");
      echo file_get_contents('img/NoCover.svg');
    }
  } else {
    echo "error. no id provided";
  }
}
?>
