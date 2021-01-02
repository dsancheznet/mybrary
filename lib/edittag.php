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

if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) { //Is the user authotized to edit tags?
  //YES
  switch ( $_POST['function'] ) { //Select the function to execute...
      case "edit": //Edit a tag
          error_log($tmpUsername+" modifies tag ".$_POST['id']." to read ".$_POST['caption']); //Error log
          if ( $myDB->setTagCaption( $_POST['id'], $_POST['caption'] ) ) { //Save the tag name to database successful?
            //YES
            echo 'ok';
          } else {
            //NO
            echo 'error';
          }
          break; //Escape switch block
      case "delete": //Remove a tag from database
          error_log($tmpUsername+" deletes tag ".$_POST['id']."/".$_POST['caption']); //Error Log
          if ( $myDB->eraseTagFromDB( $_POST['id'] ) ) { //Remove the tag from database successful?
            //YES
            echo 'ok';
          } else {
            //NO
            echo 'error';
          }
          break; // Escape switch block
      case "create": //Create a new tag
          error_log($tmpUsername+" creates tag ".$_POST['caption']); //Error Log
          if ( $myDB->setNewTag($_POST['caption']) ) { //Is the create tag successful?
            //YES
            echo 'ok';
          } else {
            //NO
            echo 'error';
          }
          break; // Escape switch block
      default:
          echo "error: no function was selected";
  }
}
