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

  if ( intdiv( (int)$tmpUserRole & (int)4, 4) ) {

  ?>
  <!-- HTML CODE -->


  <button class="uk-modal-close-default" type="button" uk-close></button>
  <h4>· Users ·</h4>

  <!-- /HTML CODE -->
  <?php

  print_r($myDB->getUserList());

  }
  ?>
