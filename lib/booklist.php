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

if ( $myDB->getBookCount() > 0 ) { //Are there books to list?
  //YES
	$tmpBooks = $myDB->getBookList( //Retrieve the book list with specified options
                                  (isset($_POST['type']))?$_POST['type']:"",
                                  (isset($_POST['search']))?$_POST['search']:"",
                                  (isset($_POST['tag']))?$_POST['tag']:""
                                );
  $tmpBookCounter = 0;
	foreach ( $tmpBooks as $tmpBook ) { //Iterate over books; Attention: variable names are different (plural vs singular)
      $tmpBookCounter++;
			echo '<div><div class="uk-card uk-card-large uk-card-default uk-padding-small" style="min-width: 200px;"><div class="uk-card-media-top uk-padding-small ">';
			if ( $myDB->bookHasCover( $tmpBook['uuid'] ) ) { //Does the book hace a cover?
        //YES
      	echo '<a href="#modal-dash" onclick="ShowBookEditModal('.$tmpBook['id'].')" uk-toggle><img src="data/covers/'.$tmpBook['uuid'].'.jpg" width="500px" alt=""></a></div>';
			} else {
        //NO
				echo '<img src="img/NoCover.svg" width="500px" alt=""></div>';
			}
			echo '<div class="uk-card-body uk-padding-remove"><span class="uk-text-bold">'.$tmpBook['title'].'</span>';
			echo '<span class="uk-text-small uk-align-center">'.$tmpBook['author'].'</span>';
			echo '<span uk-icon="icon: tag"></span><span class="uk-text-small">'.implode(', ', $myDB->getTagsForBook($tmpBook['id'])).'</span>';
			echo '<span class="uk-label uk-align-center uk-text-center uk-margin-small-top uk-margin-small-bottom" onclick="window.open(\'https://isbnsearch.org/isbn/'.$tmpBook['isbn'].'\');">ISBN '.$tmpBook['isbn'].'</span>';
			echo insertBookMenu( $tmpBook['id']);
			echo '</div></div></div>';
	}
  echo '<input type="hidden" id="books-shown" value="'.$tmpBookCounter.'">';
} else {
    echo '</div></div>';
    echo '<div class="uk-container-center">No books found in your library</div>';
}

?>
