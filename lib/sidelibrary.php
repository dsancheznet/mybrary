<?php

  include_once( 'user-functions.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();
  $tmpUserRole = $myDB->getRole( $tmpUsername );
  //Is the user logged in on do we have valid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
    //NO
    //Stop script (not neccessary but recommended)
    echo "Access Denied. <br />";
    echo "Unable to verify your session.";
    exit();
  } else {
    $tmpTypeCount = [
                        "pdf"=>$myDB->getTypeCount('pdf'),
                        "epub"=>$myDB->getTypeCount('epub'),
                        "md"=>$myDB->getTypeCount('md'),
                        "txt"=>$myDB->getTypeCount('txt'),
                      ];
    $tmpBookCount = $myDB->getBookCount();
?>
  <h5>Library Statistics</h5>
  <div>
    <span class="uk-text-small">PDF <small>(<?php echo $tmpTypeCount['pdf'];?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $tmpTypeCount['pdf'];?>" max="<?php echo $tmpBookCount;?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">EPUB <small>(<?php echo $tmpTypeCount['epub'];?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $tmpTypeCount['epub'];?>" max="<?php echo $tmpBookCount;?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">TXT <small>(<?php echo $tmpTypeCount['md'];?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $tmpTypeCount['md'];?>" max="<?php echo $tmpBookCount;?>"></progress>
  </div>
  <div>
    <span class="uk-text-small">MD <small>(<?php echo $tmpTypeCount['txt'];?>)</small></span>
    <progress class="uk-progress primary" value="<?php echo $tmpTypeCount['txt'];?>" max="<?php echo $tmpBookCount;?>"></progress>
  </div>
<?php
  }
?>
