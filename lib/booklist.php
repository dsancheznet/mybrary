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

        insertBookCard( $tmpBook );

  	}
    echo '<input type="hidden" id="books-shown" value="'.$tmpBookCounter.'">';
  } else {
      echo '</div></div>';
      echo '<div class="uk-container-center" style="width: 100%;">No books found in your library</div>';
  }
}
?>
