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
    if ( isset( $_POST['function'] ) ) {
      $tmpBookID = $_POST['bookid'];
      $tmpBookUUID = $myDB->getBookUUID( $tmpBookID );
      switch ( $_POST['function'] ) {
        case "book": //There is no missing break command here. It was intentionally omitted to trigger the deletion of a cover after a book is deleted
            if ( $myDB->eraseBookFromDB($tmpBookID) ) {
              echo "ok";
            } else {
              echo "error";
            }
        case "cover": //This gets triggered together with book deletion or alone.
            unlink( MYBRARY_MEDIA_PATH.'covers/'.$tmpBookUUID.'.jpg' );
            break;
        case deafault:
            echo "error. no function found";
      }

    } else {
      echo "error. no function selected";
    }

}
?>
