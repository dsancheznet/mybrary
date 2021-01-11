<?php

  //Version string to be displayed on the lateral panel
  define("MYBRARY_VERSION", "1.2");
  //Do we want debug messages on the console (mainly the sql statements)?
  define("MYBRARY_DEBUG", true );
  //Forbid direct access to books?
  // This setting allows you to store the media mada out of the web-path
  // of your web server, so the books are only available to authenticated
  // users. If you set this to true, you will have to adjust the MYBRARY_DB_PATH
  // and the MYBRARY_MEDIA_PATH
  define("MYBRARY_HIDE_BOOKS", true );
  //Define the location of the database (relative to root or absolute)
  // If you have set MYBRARY_HIDE_BOOKS you have to provide an absolute path on
  // your filesystem e.g. /home/user/mybrary.db otherwise an external attacker
  // could download your database and bruteforce your passwords offline. You must
  // assure that the file is writeable to the webserver user or group.
  define("MYBRARY_DB_PATH","db/mybrary.db");
  //Define the media path ( relative path to script )
  // This path has to be reachable by the webserver and writeable to the process.
  // It has to be located OUTSIDE of the webserver directories. This way, only
  // authenticated users have access to the media.
  define("MYBRARY_MEDIA_PATH", "data/");
  //Define the base path, where mybrary is installed. (unused)
  define("MYBRARY_BASE_PATH", "");
  //Define the cover stream script ( for NAS installations )
  define("MYBRARY_COVER_STREAMER","getcover.php");
  //Define the book stream script ( for NAS installations )
  define("MYBRARY_BOOK_STREAMER","getbook.php");
  //Try to extract covers from supported books (pdf)
  define("MYBRARY_EXTRACT_COVER", true );
  //Activate chunk download (this preserves memory on low power machines)
  define("MYBRARY_DOWNLOAD_CHUNKS", true );
  //Maximum siza of a chunk (1024*1024 bytes = 1MB)
  define("MYBRARY_MAX_CHUNK_SIZE", 1048576 );

?>
