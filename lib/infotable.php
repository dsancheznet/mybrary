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
<div>
  <span class="uk-text-small"><span data-uk-icon="icon:users" class="uk-margin-small-right uk-text-primary"></span>Users</span>
  <h5 class="uk-heading-primary uk-margin-remove  uk-text-primary">
<?php
    echo $myDB->getUserCount();
?>
  </h5>
</div>
<div>
  <span class="uk-text-small"><span data-uk-icon="icon:album" class="uk-margin-small-right uk-text-primary"></span>Shown</span>
  <h5 id="book-count" class="uk-heading-primary uk-margin-remove uk-text-primary">
<?php
    echo $myDB->getBookCount();
?>
  </h5>
</div>
<div>
  <span class="uk-text-small"><span data-uk-icon="icon:tag" class="uk-margin-small-right uk-text-primary"></span>Tags</span>
  <h5 class="uk-heading-primary uk-margin-remove uk-text-primary">
<?php
    echo $myDB->getTagCount();
?>
  </h5>
</div>
