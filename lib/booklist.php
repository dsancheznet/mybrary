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

if ( $myDB->getBookCount() > 0 ) {
	$tmpBooks = $myDB->getBookList( $_POST['type'], $_POST['search'], $_POST['tag'] );
	foreach ( $tmpBooks as $tmpBook ) { //Attention: variable names are different (plural vs singular)
			echo '<div><div class="uk-card uk-card-large uk-card-default uk-padding-small" style="min-width: 200px;"><div class="uk-card-media-top uk-padding-small ">';
			error_log("Looking for cover ".$tmpBook['uuid']);
			if ( $myDB->bookHasCover( $tmpBook['uuid'] ) ) {
				echo '<img src="data/covers/'.$tmpBook['uuid'].'.jpg" width="500px" alt=""></div>';
			} else {
				echo '<img src="img/NoCover.svg" width="500px" alt=""></div>';
			}
			echo '<div class="uk-card-body uk-padding-remove"><span class="uk-text-bold">'.$tmpBook['title'].'</span>';
			echo '<span class="uk-text-small uk-align-center">'.$tmpBook['author'].'</span>';
			echo '<span uk-icon="icon: tag"></span><span class="uk-text-small">'.implode(', ', $myDB->getTagsFor($tmpBook['id'])).'</span>';
			echo '<span class="uk-label uk-align-center uk-text-center uk-margin-small-top uk-margin-small-bottom" onclick="window.open(\'https://isbnsearch.org/isbn/'.$tmpBook['isbn'].'\');">ISBN '.$tmpBook['isbn'].'</span>';
			echo insertBookMenu( $tmpBook['id']);
			echo '</div></div></div>';
	}

} else {
    echo '</div></div>';
    echo '<div class="uk-container-center">No books found in your library</div>';
}
?>
