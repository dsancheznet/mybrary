<?php

include_once('config.php');
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
    <li uk-tooltip="title: View;pos: bottom"><a href="lib/view.php?id='.$tmpBook['id'].'" uk-icon="icon: file-pdf" target="_blank" rel="noopener noreferrer"></a></li>
    <li uk-tooltip="title: Download;pos: bottom"><a href="lib/download.php?id='.$tmpBook['id'].'" uk-icon="icon: cloud-download" target="_blank" rel="noopener noreferrer"></a></li>
    <li uk-tooltip="title: Summary;pos: bottom"><a href="#modal-dash" uk-icon="icon: file-text" onclick="ShowBookSummary('.$tmpBook['id'].')" uk-toggle></a></li>
    <li uk-tooltip="title: Delete;pos: bottom"><a uk-icon="icon: trash" onclick="DeleteBookWithId('.$tmpBook['id'].')"></a></li>
    </ul>';
  }

  function insertBookCard( $tmpBook, $tmpContentOnly = false ) {
    $myDB = new Database();
    if ( !$tmpContentOnly ) { echo '<div id="book-card-'.$tmpBook['id'].'">'; }

/* Alternative look (I'm experimeting with this...)
    echo '<div class="uk-card uk-card-small uk-width-1-1">';
    echo '<div class="uk-card-header">';
    echo '<div class="uk-grid-small uk-flex-middle" uk-grid>';
    echo '<div class="uk-width-auto">';
    echo '<img class="uk-border-rounded" width="100" id="booklist-img-'.$tmpBook['uuid'].'" src="lib/getcover.php?uuid='.$tmpBook['uuid'].'">';
    echo '</div>';
    echo '<div class="uk-width-expand">';
    echo '<p class="uk-card-title uk-margin-remove-bottom uk-text-small">'.$tmpBook['title'].'</p>';
    echo '<p class="uk-text-meta uk-margin-remove-top">'.$myDB->getBookSize( $tmpBook['id'] ).'</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="uk-card-body">';
    echo '<p>'.$tmpBook['author'].'<br />'.'<span class="uk-margin-small-right" uk-icon="icon: tag"></span><small>'.implode(', ', $myDB->getTagsForBook($tmpBook['id'])).'</small></p>';
    echo '</div>';
    echo '<div class="uk-card-footer">';
    insertBookMenu( $tmpBook );
    echo '</div>';
    echo '</div>';
*/

    echo '<div class="uk-card uk-card-large uk-card-default uk-padding-small" style="min-width: 200px;">
          <div class="uk-card-media-top">';
    echo '<a href="#modal-dash" onclick="ShowBookEditModal('.$tmpBook['id'].')" uk-toggle>
            <img id="booklist-img-'.$tmpBook['id'].'" class="uk-border-rounded" src="lib/getcover.php?uuid='.$tmpBook['uuid'].'" width="500px" alt="" uk-tooltip="title: Uploader: '.$myDB->getBookUploader($tmpBook['id']).' ;pos: top">
          </a>
          </div>';
    echo '<div class="uk-card-body uk-padding-remove">
          <span class="uk-text-bold">'.$tmpBook['title'].'
          </span><br />';
    echo '<div class="uk-align-right">
          <small class="uk-text-muted"><b>
          '.$myDB->getBookType( $tmpBook['id'] )."</b>, ".$myDB->getBookSize( $tmpBook['id'] ).'
          </small>
          </div><br />';
    echo '<div>
          '.$tmpBook['author'].'
          </div><br />';
    echo '<span class="uk-margin-small-right" uk-icon="icon: tag"></span>
          <small>
          '.implode(', ', $myDB->getTagsForBook($tmpBook['id'])).'
          </small>';
    echo '<span class="uk-label uk-align-center uk-text-center uk-margin-small-top uk-margin-small-bottom" onclick="window.open(\'https://isbnsearch.org/isbn/'.$tmpBook['isbn'].'\');">
            ISBN '.$tmpBook['isbn'].'
          </span>';
    echo insertBookMenu( $tmpBook );
    echo '</div>
          </div>';

    if ( !$tmpContentOnly ) { echo '</div>'; }
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

?>
