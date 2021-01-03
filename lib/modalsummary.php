<?php
  include_once( 'user-classes.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();

//Is the user logged in on do we have valid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
    //NO
    //Stop script (not neccessary but recommended)
    echo "Access Denied. <br />";
    echo "Unable to verify your session.";
    exit();
  }
?>

<button class="uk-modal-close-default" type="button" uk-close></button>

<h4>· Book Summary ·</h4>

<?php

  if (isset($_POST['bookid'])) { //Do we have a bookid?
    //YES
    $tmpBookID = $_POST['bookid']; //Capture it.
    $tmpSummary = $myDB->getBookSummary( $tmpBookID ); //Get the summary for it.
    echo ($tmpSummary=="")?'<span class="uk-text-primary">No summary available</span>':$tmpSummary; //Print info or summary if available
  } else {
    echo "error. no bookid found"; //error message
  }

?>
