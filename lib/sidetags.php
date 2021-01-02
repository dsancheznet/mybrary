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

  $tmpTags = $myDB->getTagList(); //Retrieve Taglist
  foreach ($tmpTags as $tmpArray) { //Iterate over each of them
    echo '<li>
          <a title="'.$tmpArray['caption'].'" onclick="RegisterTagSearch('.$tmpArray['id'].')">'.$tmpArray['caption'].'
          </a>
          </li>';
  }

?>
