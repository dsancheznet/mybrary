<?php
  //Delete all session variables
  unset($_SESSION);
  //Send the browser back to login
  header("Location: login.php");
  exit();
?>
