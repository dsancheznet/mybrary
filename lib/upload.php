<?php
  include_once( 'user-classes.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();

//Is the user logged in on do we have valid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) or ( !isset($tmpUsername) ) or ( !isset($tmpPassword) ) ) {
    //NO
    //Stop script (not neccessary but recommended)
    echo "Access Denied. <br />";
    echo "Unable to verify your session.";
    exit();
  } elseif ( ( (int)$myDB->role( $tmpUsername ) & (int)2 ) == 0 ) {
      echo "Acces denied. <br/>";
      echo "You are not allowed to upload.";
      exit();
  }

?>

<button class="uk-modal-close-default" type="button" uk-close></button>

<h4>· Upload File ·</h4>

<div class="js-upload uk-placeholder uk-text-center">
    <span uk-icon="icon: cloud-upload"></span>
    <span class="uk-text-middle">Attach binaries by dropping them here or</span>
    <div uk-form-custom>
        <input type="file" multiple>
        <span class="uk-link">selecting one</span>
    </div>
</div>

<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

<div id="result-panel"></div>
