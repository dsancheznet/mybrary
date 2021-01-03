<?php
  include_once( 'user-classes.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];
  $tmpUserToModify = $_GET['nm'];

  $myDB = new Database();

//Is the user logged in and do we have valid credentials?
  if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
    //NO
    //Stop script (not neccessary but recommended)
    echo "Access Denied. <br />";
    echo "Unable to verify your session.";
    exit();
  } elseif ( $tmpUserToModify <> $tmpUsername ) {
    if ( ( (int)$myDB->getRole( $tmpUsername ) & (int)4 ) == 0 ) {
      echo "Acces denied. <br/>";
      echo "You are not an admin.";
      exit();
    }
  }
?>

<button class="uk-modal-close-default" type="button" uk-close></button>

<h4>· User Data ·</h4>

<img id="avatar-image" class="uk-align-center" src="../img/avatars/<?php echo $myDB->getAvatar( $tmpUserToModify ); ?>" width="100px;">
<!--<form>-->
  <label class="uk-form-label" for="form-stacked-select">Avatar</label>
    <select id="avatar-selector" class="uk-select" onchange="AvatarChanged()">
<?php
      chdir('img/avatars');
      $tmpAvatarList = glob('./*.svg');
      foreach($tmpAvatarList as $tmpAvatar){
        echo '<option value="'.basename($tmpAvatar).'">'.basename($tmpAvatar).'</option>';
      }
      chdir('../../');
?>
    </select>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-select">Username</label>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: user"></span>
            <input id="user-username" class="uk-input<?php
            if ( ( (int)$myDB->getRole( $tmpUsername ) & (int)4 ) == 0 )  { echo " uk-disabled"; }?>" type="text" value="<?php echo $tmpUserToModify?>">
        </div>
    </div>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-select">Full Name</label>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: user"></span>
            <input id="user-fullname" class="uk-input" type="text" value="<?php echo $myDB->getFullName($tmpUserToModify);?>">
        </div>
    </div>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-select">New Password</label>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input id="user-passwd1" class="uk-input" type="password">
        </div>
    </div>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-select">New Password (Repeat)</label>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input id="user-passwd2" class="uk-input" type="password">
        </div>
    </div>

    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">

<?php

  $tmpRole = (int)$myDB->getRole( $tmpUserToModify );
  if ( ( (int)$myDB->getRole( $tmpUsername ) & 4 ) == 4 ) { //If you are admin, you can change userlevels.
    echo '<label><input id="user-readerchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 1) == 1 )?'checked':'';
    echo '> Reader </label>';
    echo '<label><input id="user-userchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 2) == 2 )?'checked':'';
    echo '> Uploader </label>';
    echo '<label><input id="user-adminchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 4) == 4 )?'checked':'';
    echo '> Administrator </label>';
  } else {
    echo '<label><input id="user-readerchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 1) == 1 )?'checked':'';
    echo ' disabled> Reader </label>';
    echo '<label><input id="user-userchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 2) == 2 )?'checked':'';
    echo ' disabled> Uploader </label>';
    echo '<label><input id="user-adminchk" class="uk-checkbox" type="checkbox" ';
    echo (((int)$myDB->getRole($tmpUserToModify) & 4) == 4 )?'checked':'';
    echo ' disabled> Administrator </label>';
  }
?>

      <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-remove-bottom uk-margin-top" onclick="SaveUserData()" uk-toggle="target: #modal-dash"><span class="uk-margin-small-right" uk-icon="download"></span>Save</button>
    </div>
<!--</form>-->
