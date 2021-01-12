<?php


  include_once( 'user-functions.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();

  if ( isset( $_GET['id'] ) ) {

    echo insertBookCard( $myDB->getBookArray($_GET['id']) , true );

  } else {
    echo "error: missing book";
  }


?>
