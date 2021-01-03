<?php
  include_once('user-classes.php');
  chdir('..');
  //Start the session to be able to read back the stored variables
  session_start();
  //Read the variables from session storage
  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  //Is the user not logged in and do we have invalid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) or ($tmpUsername=="") or $tmpPassword=="") {
      echo "Error: You are not logged in";
  } else {
    if ( isset( $_FILES['files'] ) ) {
      $tmpCoverStorage = 'data/covers/';
      $myDB = new Database( 'db/mybrary.db' );
      $tmpUUID = $myDB->getBookUUID($_GET['id']);
      if ( file_exists($tmpCoverStorage.$tmpUUID.".jpg")) {
        unlink($tmpCoverStorage.$tmpUUID.".jpg");
      }
      if ( move_uploaded_file( $_FILES['files']['tmp_name'][0], $tmpCoverStorage.$tmpUUID.".jpg" ) ) {
            echo "ok";
          } else {
          echo "error: could not move the file from ".$tmpFileName." to ".$tmpBookStorage.$tmpFileName.".".$tmpFileExtension." <br />";
        }
    } else {
      echo "error: no filename";
    }
  }
?>
