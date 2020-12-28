<?php

/*
/*
----------------------------------------------------------------------
file: uuid.php
project: mybrary
summary:
  This file generates an UUID that has not been taken by any file yet.
  While it is highly unlikely that there would be two equal numbers generated,
  people do win lottery as well, so...
----------------------------------------------------------------------
*/
chdir( '..' );
//Load libraries
include_once('lib/helper-classes.php');
//Generate an uuid
$tmpUUID = array( 'uuid' => UUID::v4());
//While the file exists, do...
while ( file_exists( 'data/books/'+$tmpUUID['uuid']+'.pdf' ) or file_exists( 'data/books/'+$tmpUUID['uuid']+'.epub' ) or file_exists( 'data/books/'+$tmpUUID['uuid']+'.txt' ) or file_exists( 'data/books/'+$tmpUUID['uuid']+'.md' ) ) {
  //Generate a new uuid
  $tmpUUID = array( 'uuid' => UUID::v4());
}
//Print it back to stream, json encoded.
echo json_encode( $tmpUUID );

?>
