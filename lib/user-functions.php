<?php

include_once('helper-classes.php');

define("MYBRARY_VERSION", "1.0");
define("MYBRARY_DEBUG", false );

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
      if (MYBRARY_DEBUG) { error_log(__FILE__.' - Checking '.md5($tmpPassword)." against ".$tmpDatabase->md5Password( $tmpUsername ) ); }
      if ( md5($tmpPassword) == $tmpDatabase->md5Password( $tmpUsername ) ) {
        if (MYBRARY_DEBUG) { error_log( "Starting Session...".session_status() ); }
        session_start();
        $_SESSION['username'] = $tmpUsername;
        $_SESSION['md5pass'] = md5($tmpPassword);
        if (MYBRARY_DEBUG) { error_log( "Session status...".session_status() ); }
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

  function insertBookMenu( $tmpBook ) {
    //TODO : When the proposed change to uikit regarding mimetype icons has propagated, change the line reading "icon: file-pdf" target=" to "icon: file-'.$tmpBook['type'].'"
    return '<ul class="uk-iconnav">
    <li><a href="lib/view.php?id='.$tmpBook['id'].'" uk-icon="icon: file-pdf" target="_blank" rel="noopener noreferrer"></a></li>
    <li><a href="lib/download.php?id='.$tmpBook['id'].'" uk-icon="icon: cloud-download" target="_blank" rel="noopener noreferrer"></a></li>
    <li><a href="#modal-dash" uk-icon="icon: file-text" onclick="ShowBookSummary('.$tmpBook['id'].')" uk-toggle></a></li>
    <li><a uk-icon="icon: trash" onclick="DeleteBookWithId('.$tmpBook['id'].')"></a></li>
    </ul>';
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
    while ( file_exists( '../data/books/'.$tmpUUID.'.pdf' ) or file_exists( '../data/books/'.$tmpUUID.'.epub' ) or file_exists( '../data/books/'.$tmpUUID.'.txt' ) or file_exists( '../data/books/'.$tmpUUID.'.md' ) ) {
      //..generate a new uuid
      $tmpUUID = UUID::v4();
    }
    //Return the unique UUID
    return $tmpUUID;
  }

?>
