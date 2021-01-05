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
  }

  if ( intdiv( (int)$tmpUserRole & (int)4, 4) ) {

  ?>
  <!-- HTML CODE -->


  <button class="uk-modal-close-default" type="button" uk-close></button>
  <h4>· Users ·</h4>
  <!-- /HTML CODE -->
<?php
    $tmpUserList = $myDB->getUserList();
?>
  <table class="uk-table uk-table-striped uk-text-small uk-table-hover">
      <thead>
          <tr>
              <th>id</th>
              <th>name</th>
              <th>role</th>
              <th>options</th>
          </tr>
      </thead>
      <tbody>
<?php
      foreach ( $tmpUserList as $tmpUser ) { //Iterate over available tags; attention: variable names are different (plural vs singular)
        echo '<tr>
          <td> '.$tmpUser['username'].'
          <td>'.$tmpUser['name'].'</div> </td>
          <td>'.$tmpUser['role'].'</div> </td>
          <td>
          <span uk-icon="pencil" onclick="ShowPersonalInfoForm(\''.$tmpUser['username'].'\')"></span>
          <span uk-icon="trash" onclick="DeleteUserFromDB(\''.$tmpUser['username'].'\')"></span>
          </td>';
        echo '</tr>';
      }
?>
      </tbody>
  </table>

  <button class="uk-button uk-button-primary uk-width-1-1 uk-padding-small uk-margin-remove-bottom uk-margin-top" onclick="CreateNewUser()"><span uk-icon="plus-circle">Create new User </button>

<?php
}
?>
