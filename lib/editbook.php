<?php
  include_once( 'user-classes.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();
  $tmpUserRole = $myDB->role( $tmpUsername );
//Is the user logged in on do we have valid credentials?
if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
  //NO
  //Stop script (not neccessary but recommended)
  echo "Access Denied. <br />";
  echo "Unable to verify your session.";
  exit();
}

if ( intdiv( (int)$tmpUserRole & (int)2, 2 ) ) { //Is the user authotized to edit tags?
  //YES
  if (isset( $_POST['bookid'] )) { //Do we have a bookid supplied
    //YES
    $tmpTitle = $_POST['title'];
    $tmpAuthor = $_POST['author'];
    $tmpSummary = $_POST['summary'];
    $tmpISBN = $_POST['isbn'];
    $tmpTags = $_POST['tags'];
    if ( $myDB->setBookData( $_POST['bookid'], $tmpTitle, $tmpAuthor, $tmpSummary, $tmpISBN, $tmpTags ) ) {
        echo "bookdata saved";
    } else {
      echo "error saving bookdata";
    }
  } else {
    echo "error: bookid missing";
  }
} else {
  echo "error: you are not allowed to write data";
}
