<?php
  include_once( 'user-classes.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  $tmpUserToModify = $_GET['nm'];

  $myDB = new Database();

//Is the user logged in on do we have valid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
    //NO
    //Stop script (not neccessary but recommended)
    echo "Access Denied. <br />";
    echo "Unable to verify your session.";
    exit();
  } elseif ( $tmpUserToModify <> $tmpUsername ) {
    if ( ( (int)$myDB->role( $tmpUsername ) & (int)4 ) == 0 ) {
      echo "Acces denied. <br/>";
      echo "You are not an admin.";
      exit();
    }
  }

?>

<button class="uk-modal-close-default" type="button" uk-close></button>

<h4>· Upload File ·</h4>
