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

<!-- TODO : check for existence of bookid -->

<?php
  $tmpSummary = $myDB->getBookSummary($_POST['bookid']);
  echo ($tmpSummary=="")?'<span class="uk-text-primary uk-text-center">No summary available</span>':$tmpSummary;
?>
