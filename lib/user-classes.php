<?php

include_once('helper-classes.php');

  function checkValidUser( $tmpUsername, $tmpPassword ){
    $tmpDatabase = new Database();

    if ( !md5($tmpPassword) == $tmpDatabase->md5Password( $tmpUsername ) ) {
      return false;
    } else {
      return true;
    }
  }

  function checkSessionStatus( &$tmpUsername, &$tmpPassword ) {
    $tmpDatabase = new Database();
    if ( session_status() == PHP_SESSION_NONE ) {
      error_log(__FILE__.' - Checking '.md5($tmpPassword)." against ".$tmpDatabase->md5Password( $tmpUsername ) );
      if ( md5($tmpPassword) == $tmpDatabase->md5Password( $tmpUsername ) ) {
        error_log( "Starting Session...".session_status() );
        session_start();
        $_SESSION['username'] = $tmpUsername;
        $_SESSION['md5pass'] = md5($tmpPassword);
        error_log( "Session status...".session_status() );
        return true;
      } else {
        return false;
      }
    } else {
      $tmpUsername = $_SESSION['username'];
      $tmpPassword = $_SESSION['md5pass'];
      if (( $tmpUsername == '') and ( $tmpPassword == '') ) {
        return false;
      } else {
        return true;
      }
    }
  }

  function insertBookMenu( $tmpID ) {
    return '<ul class="uk-iconnav"><li><a href="#" uk-icon="icon: file-pdf"></a></li><li><a href="#" uk-icon="icon: file-edit"></a></li><li><a href="#" uk-icon="icon: tag"></a></li><li><a href="#" uk-icon="icon: download"></a></li><li><a href="#" uk-icon="icon: trash"></a></li></ul>';
  }

  function insertUserMenu( $tmpUserRole, $tmpUsername ) {
    echo '<div class="uk-dropdown user-drop" data-uk-dropdown="mode: click; pos: bottom-center; animation: uk-animation-slide-bottom-small; duration: 150"><ul class="uk-nav uk-dropdown-nav uk-text-left">';
    echo '<li><a href="#modal-dash" onclick="ShowPersonalInfoForm(\''.$tmpUsername.'\')" uk-toggle><span data-uk-icon="icon: user"></span> Personal Info</a></li>';
    if ( intdiv( (int)$tmpUserRole & (int)4, 4) ) {
      echo '<li><a href="#modal-dash" onclick="ShowUserAdminForm()" uk-toggle><span data-uk-icon="icon: users"></span> Users</a></li>';
    }
    if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) {
        echo '<li><a href="#modal-dash" onclick="ShowUploadForm()" uk-toggle><span data-uk-icon="icon: upload"></span> Upload</a></li>';
        echo '<li><a href="#modal-dash" onclick="ShowTagAdminForm()" uk-toggle><span data-uk-icon="icon: tag"></span> Tags</a></li>';
    }
    echo '<li><a href="logout.php"><span data-uk-icon="icon: sign-out"></span> Sign Out</a></li>';
    echo '</ul></div>';
  }

  function getNewUUID() {
    /* This function generates an UUID that has not been taken by any file yet.
    While it is highly unlikely that there would be two equal numbers generated,
    people do win lottery as well, so...*/

    //Generate an UUID
    $tmpUUID = UUID::v4();
    //While the file exists, do...
    while ( file_exists( '../data/books/'+$tmpUUID+'.pdf' ) or file_exists( '../data/books/'+$tmpUUID+'.epub' ) or file_exists( '../data/books/'+$tmpUUID+'.txt' ) or file_exists( '../data/books/'+$tmpUUID+'.md' ) ) {
      //..generate a new uuid
      $tmpUUID = UUID::v4();
    }
    //Return the unique UUID
    return $tmpUUID;
  }

?>
