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
} elseif ( isset($_POST['bookid']) ) {
    $tmpBookID = $_POST['bookid'];
    $tmpBookUUID = $myDB->getBookUUID( $tmpBookID );
    if ( $myDB->eraseBookFromDB($tmpBookID) ) {
      unlink( 'data/covers/'.$tmpBookUUID.'.jpg' );
      echo "ok";
    } else {
      echo "error";
    }

}
?>
