<?php
  include_once( 'user-functions.php' );
  chdir('..');
  session_start();

  $tmpUsername = $_SESSION['username'];
  $tmpPassword = $_SESSION['md5pass'];

  $myDB = new Database();
  $tmpUserRole = $myDB->getRole( $tmpUsername );
//Is the user logged in and do we have valid credentials?
if ( !checkSessionStatus( $tmpUsername, $tmpPassword ) ) {
  //NO
  //Stop script (not neccessary but recommended)
  echo "Access Denied. <br />";
  echo "Unable to verify your session.";
  exit();
}

if ( isset($_POST['function']) ) { //Is the user authotized to edit users?
  //YES
  switch ( $_POST['function'] ) { //Select the function to execute...
      case "edit": //Edit a tag
          if (isset($_POST['username'])) {
            if ( isset($_POST['fullname'])) {
              echo ($myDB->setUserFullname( $_POST['username'], $_POST['fullname']))?"ok ":"error setting full name";
            }
            if ( isset($_POST['avatar'])) {
              echo ($myDB->setUserAvatar( $_POST['username'], $_POST['avatar'] ))?"ok ":"error setting avatar";
            }
            if ( isset($_POST['password']) and ( $_POST['password']<>"" ) ) {
              if ( $myDB->setUsermd5Password( $_POST['username'], md5($_POST['password']) ) ) {
                echo "ok ";
                $_SESSION['md5pass']=md5($_POST['password']);
              } else {
                echo "error changing password";
              }
            }
            if ( isset($_POST['role']) and ( $_POST['role']>0 )) {
              echo ( $myDB->setUserRole( $_POST['username'], $_POST['role'] ) )?"ok ":"error setting role";
            }
          } else {
            echo "error: no username provided";
          }
          break; //Escape switch block
      case "delete": //Remove a tag from database
          if (isset($_POST['username'])) {
            if ( $myDB->eraseUserFromDB( $_POST['username'] ) ) {
              echo "ok";
            } else {
              echo "error deleting user";
            }
          } else {
            echo "error: no username provided";
          }
          break; // Escape switch block
      case "create": //Create a new tag
          if (isset( $_POST['username'] )) {
            if ( $myDB->setNewUser( $_POST['username'] ) ) {
              echo "ok";
            } else {
              echo "error creating user";
            }
          } else {
            echo "error: no username provided";
          }
          break; // Escape switch block
      default:
          echo "error: no function was selected";
  }
} else {
  echo "error: no funcion selected";
}
