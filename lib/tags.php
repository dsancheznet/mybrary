<?php
  include_once( 'user-classes.php' );
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

if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) {

  $tmpTags = $myDB->getTagList();

?>
<!-- HTML CODE -->


<button class="uk-modal-close-default" type="button" uk-close></button>
<h4>· Tags ·</span></h4>

<table class="uk-table uk-table-striped uk-text-small uk-table-hover">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>options</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach ( $tmpTags as $tmpTag ) { //Iterate over available tags; attention: variable names are different (plural vs singular)
      echo '<tr>';
        echo '<td> '.$tmpTag['id'].' </td>';
        echo '<td>'.$tmpTag['caption'].'</div> </td>';
        echo '<td><span uk-icon="pencil" onclick="EditTag( \''.$tmpTag['id'].'\', \''.$tmpTag['caption'].'\' )"></span><span uk-icon="trash" onclick="DeleteTag( \''.$tmpTag['id'].'\', \''.$tmpTag['caption'].'\' )"></span></td>';
      echo '</tr>';
    }
?>
    </tbody>
</table>

<button class="uk-button uk-button-primary uk-width-1-1 uk-padding-small uk-margin-remove-bottom uk-margin-top" onclick="ReadAndCreateTag()"><span uk-icon="plus-circle">Create new Tag </button>


<!-- /HTML CODE -->
<?php



}
?>
