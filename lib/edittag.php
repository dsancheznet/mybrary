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

if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) {

  switch ( $_POST['function'] ) {
      case "edit":
          error_log($tmpUsername+" modifies tag ".$_POST['id']." to read ".$_POST['caption']);
          if ( $myDB->setTagCaption( $_POST['id'], $_POST['caption'] ) ) {
            echo 'ok';
          } else {
            echo 'error';
          }
          break;
      case "delete":
          error_log($tmpUsername+" deletes tag ".$_POST['id']."/".$_POST['caption']);
          if ( $myDB->eraseTagFromDB( $_POST['id'] ) ) {
            echo 'ok';
          } else {
            echo 'error';
          }
          break;
      case "create":
          error_log($tmpUsername+" creates tag ".$_POST['caption']);
          if ( $myDB->setNewTag($_POST['caption']) ) {
            echo 'ok';
          } else {
            echo 'error';
          }
          break;
  }
}
