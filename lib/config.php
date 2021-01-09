<?php

  //Version string to be displayed on the lateral panel
  define("MYBRARY_VERSION", "1.1");
  //Do we want debug messages on the console (mainly the sql statements)?
  define("MYBRARY_DEBUG", true );
  //Forbid direct access to books?
  define("MYBRARY_HIDE_BOOKS", true );
  //Define the location of the database (relative to root or absolute)
  define("MYBRARY_DB_PATH","db/mybrary.db");
  //Define the media path ( relative path to script )
  define("MYBRARY_MEDIA_PATH", "data/");
  //Define the base path, where mybrary is installed.
  define("MYBRARY_BASE_PATH", "");
  //Define the cover stream script ( for NAS installations )
  define("MYBRARY_COVER_STREAMER","getcover.php");
  //Define the book stream script ( for NAS installations )
  define("MYBRARY_BOOK_STREAMER","getbook.php");
  //Try to extract covers from supported books (pdf)
  define("MYBRARY_EXTRACT_COVER", true );

?>
