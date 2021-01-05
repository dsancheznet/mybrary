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
  if ( isset( $_GET['id'] ) ) { //Do we hace an ID?
    //YES
    $tmpMimeType = [ //Declare valid MIME types
        'pdf'=>'application/pdf',
        'epub'=>'application/epub+zip',
        'md'=>'text/markdown',
        'txt'=>'text/plain'
    ];
    $tmpFileType = $myDB->getBookType( $_GET['id'] );
    $tmpFilepath = 'data/books/'; //This is the relative path to all books
    $tmpFile = $tmpFilepath.$myDB->getBookUUID( $_GET['id'] ).'.'.$tmpFileType ); //Contruct a valid filename
    $tmpFileData = file_get_contents( $tmpFile );
    if ( file_exists( $tmpFile ) ) { //Does the file exist?
      //YES
      $tmpFileName = $myDB->getBookTitle( $_GET['id'] ).".".$tmpFileType ); //Construct a valid filename
      header('Content-disposition: attachment; filename='.$tmpFileName );
      header('Content-type: '.$tmpMimeType[ $tmpFileType ] );
      header('Content-Length: '.filesize($tmpFile));
      header("Pragma: no-cache");
      header("Expires: 0");
      echo $tmpFileData;
    } else {
      //NO
      echo "error. file does no exist";
      exit;
    }
  } else {
    //NO
    echo "error. no bookid provided";
    exit;
  }
}
