<?php
  include_once('user-classes.php');

  if ( isset( $_FILES['files'] ) ) {
    $tmpNewUUID = getNewUUID();
    $tmpBookStorage = "../data/books/";
    $tmpFileName = $_FILES['files']['tmp_name'][0];
    $tmpFileExtension = strtolower(end(explode('.',$_FILES['files']['filename'][0])));
    if ( move_uploaded_file( $tmpFileName, $tmpBookStorage.$tmpFileName.".".$tmpFileExtension ) ) {
      echo $tmpBookStorage.$tmpFileName.".".$tmpFileExtension;
    } else {
      echo "Error: Cound not move the file from ".$tmpFileName." to ".$tmpBookStorage.$tmpNewUUID.".".$tmpFileExtension[1]." <br />";
      print_r( $_FILES['files'] );
    }
  } else {
    echo "Error: No filename";
  }

?>
