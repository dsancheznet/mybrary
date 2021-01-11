<?php
  include_once( 'user-functions.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  $myDB = new Database();

  $tmpUserRole = $myDB->getRole( $tmpUsername );
//Is the user logged in on do we have valid credentials?
/*
if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
  //NO
  //Stop script (not neccessary but recommended)
  echo "Access Denied. <br />";
  echo "Unable to verify your session.";
  exit();
} else {
*/
  if ( isset( $_GET['id'] ) ) { //Do we have an ID?
    //YES
    $tmpShortenedID = $_GET['id'];
    $tmpBookTitle = $myDB->getBookTitle( $tmpShortenedID );
    $tmpBookUUID = $myDB->getBookUUID( $tmpShortenedID );
    $tmpBookType = $myDB->getBookType( $tmpShortenedID );
    //Send header depending on filetype
    switch ( $tmpBookType ) { //These are the official MIME-types for supported filetypes
      case "pdf":
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.$tmpBookUUID.'.pdf"');
        break;

      case "epub":
        header('Content-Type: application/epub+zip');
        header('Content-Disposition: inline; filename="'.$tmpBookUUID.'.epub"');
        break;

      case "md":
        header('Content-Type: text/markdown');
        header('Content-Disposition: inline; filename="'.$tmpBookUUID.'.md"');
        break;

      case "txt":
        header('Content-Type: text/plain');
        header('Content-Disposition: inline; filename="'.$tmpBookUUID.'.txt"');
        break;
    }
    header('Content-Length: '.filesize( MYBRARY_MEDIA_PATH.'books/'.$tmpBookUUID.'.'.$tmpBookType ));
    header("Pragma: no-cache");
    header("Expires: 0");
    //Does the filename exist (it should, since it is in the DB)?
    if ( file_exists( MYBRARY_MEDIA_PATH.'books/'.$tmpBookUUID.'.'.$tmpBookType  ) ) {
      //YES
      if ( MYBRARY_DOWNLOAD_CHUNKS ) {

        $tmpFile = fopen( MYBRARY_MEDIA_PATH.'books/'.$tmpBookUUID.'.'.$tmpBookType, 'rb');
        while (!feof($tmpFile))
        {
            $tmpBuffer = fread( $tmpFile, MYBRARY_MAX_CHUNK_SIZE );
            echo $tmpBuffer;
            ob_flush();
            flush();
        }
        fclose( $tmpFile );

      } else {
        //Print back the filedata (one big chunk)
        echo file_get_contents( MYBRARY_MEDIA_PATH.'books/'.$tmpBookUUID.'.'.$tmpBookType );
      }
    } else {
      //NO (this MUST be a library error)
      echo "error. database inconsistency / file not found";
    }
  } else {
    echo "error. no id provided";
  }
//}
?>
