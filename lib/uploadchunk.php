<?php
  include_once('user-functions.php');
  chdir('..');
  //Start the session to be able to read back the stored variables
  session_start();
  //Read the variables from session storage
  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  $myDB = new Database();
  //Is the user not logged in and do we have invalid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) or ($tmpUsername=="") or $tmpPassword=="") {
      echo "error: not logged in";
  } else {
    if ( isset( $_FILES['files'] ) ) {
      for ( $tmpCounter = 0; $tmpCounter < count( $_FILES['files']['name'] ); $tmpCounter++ ) {
        $tmpNewUUID = $myDB->getNewBookUUID();
        $tmpBookStorage = MYBRARY_MEDIA_PATH."books/";
        $tmpCoverStorage = MYBRARY_MEDIA_PATH."covers/";
        $tmpFileName = $_FILES['files']['tmp_name'][$tmpCounter];
        switch ( $_FILES['files']['type'][$tmpCounter] ) {
          case 'application/pdf':
              $tmpFileExtension = 'pdf';
              break;
          case 'application/epub+zip':
              $tmpFileExtension = 'epub';
              break;
          case 'text/markdown':
              $tmpFileExtension = 'md';
              break;
          case 'text/plain':
              $tmpFileExtension = 'txt';
              break;
          /* I'll leave this prepared for comics as well, until I find a suitable reader
          case '':
              $tmpFileExtension = 'cbr';
              break;
          case '':
              $tmpFileExtension = 'cbz';
              break;*/
          default:
              echo "error: no recognized file format detected";
              exit;
        }
        if ( move_uploaded_file( $tmpFileName, $tmpBookStorage.$tmpNewUUID.".".$tmpFileExtension ) ) {
          if ( $myDB->setNewBook( $tmpNewUUID, $_FILES['files']['name'][$tmpCounter], $tmpFileExtension, $tmpUsername ) ) {
            echo "ok";
            if ( ( $tmpFileExtension=='pdf' ) and ( MYBRARY_EXTRACT_COVER ) ) {
              exec("convert ".$tmpBookStorage.$tmpNewUUID.".".$tmpFileExtension."[0] ".$tmpCoverStorage.$tmpNewUUID.".jpg");
            }
          }
        } else {
          echo "error: could not move the file from ".$tmpFileName." to ".$tmpBookStorage.$tmpFileName.".".$tmpFileExtension." <br />";
        }
      }
    } else {
      echo "error: no filename";
    }
  }
?>
