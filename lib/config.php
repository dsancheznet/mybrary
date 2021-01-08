<?php

  //Version string to be displayed on the lateral panel
  define("MYBRARY_VERSION", "1.1");
  //Do we want debug messages on the console (mainly the sql statements)?
  define("MYBRARY_DEBUG", true );
  //Forbid direct access to books?
  define("MYBRARY_HIDE_BOOKS", false );
  //Define the location of the database (relative to root or absolute)
  define("MYBRARY_DB_PATH","db/mybrary.db");
  //Define the media path ( relative path to script )
  define("MYBRARY_MEDIA_PATH", "data/");
  //Define the cover stream script ( for NAS installations )
  define("MYBRARY_COVER_STREAMER","getcover.php");
  //Define the book stream script ( for NAS installations )
  define("MYBRARY_BOOK_STREAMER","getbook.php");

?>
