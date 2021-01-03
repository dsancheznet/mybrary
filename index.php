<?php
/*
----------------------------------------------------------------------
file: index.php
project: mybrary
summary:
  This file is to be called first. If the user is logged in, with
  an active session, he or she will be redirected to the dashboard.
  If the user is not logged in, he or she will be redirected to the
  login form.
----------------------------------------------------------------------
*/

//Import all user settings
  include_once( 'lib/user-functions.php' );
//Declare user variables - even if they are not set (will be empty)
  $tmpUsername = $_POST['username'];
  $tmpPassword = $_POST['password'];
  error_log( "Username:".$tmpUsername." Password:".$tmpPassword );
//Is the user logged in on do we have valid credentials?
  if ( checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
    //YES : Goto dashboard
    header("Location: dashboard.php");
    //Stop script (not neccessary but recommended)
    exit();
  } else {
    //NO : Go back to the login form
    header("Location: login.php");
    //Stop script (not neccessary but recommended)
    exit();
  }

?>
