<?php


  include_once( 'user-functions.php' );
  chdir('..');

  if ( isset( $_GET['id'] ) ) {

    $myDB = new Database();
    echo 'lib/getcover.php?uuid='.$myDB->getBookUUID( $_GET['id'] )."&t=".date("hms");

  } else {
    echo "error: missing book";
  }


?>
