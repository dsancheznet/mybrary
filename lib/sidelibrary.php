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
?>
  <h5>Library Statistics</h5>
  <div>
    <span class="uk-text-small">PDF <small>(<?php echo $myDB->getTypeCount('pdf')?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $myDB->getTypeCount('pdf')?>" max="<?php echo $myDB->getBookCount();?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">EPUB <small>(<?php echo $myDB->getTypeCount('epub')?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $myDB->getTypeCount('epub')?>" max="<?php echo $myDB->getBookCount();?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">TXT <small>(<?php echo $myDB->getTypeCount('txt')?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $myDB->getTypeCount('txt')?>" max="<?php echo $myDB->getBookCount();?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">MD <small>(<?php echo $myDB->getTypeCount('md')?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $myDB->getTypeCount('md')?>" max="<?php echo $myDB->getBookCount();?>"></progress>
  </div>
