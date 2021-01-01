<?php

  class Database {

    private $CONN = "";

    function __construct( ) {
      $this->CONN = new SQLite3( 'db/mybrary.db' );
    }

    function md5Password( $tmpUsername ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT md5pass FROM users WHERE username="'.$tmpUsername.'"' );
      return $tmpDataset;
    }

    function name( $tmpUsername ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT name FROM users WHERE username="'.$tmpUsername.'"' );
      return $tmpDataset;
    }

    function role( $tmpUsername ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT role FROM users WHERE username="'.$tmpUsername.'"' );
      return $tmpDataset;
    }

    function rolename( $tmpUsername ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT role FROM users WHERE username="'.$tmpUsername.'"' );
      $tmpRolenames = ['Reader', 'User', 'User', 'User', 'User', 'User', 'Administrator']; // Following Flags (bitwise): 001 = Read, 010 = Upload, 100 = Administrator
      return $tmpRolenames[$tmpDataset-1];
    }

    function avatar( $tmpUsername ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT avatar FROM users WHERE username="'.$tmpUsername.'"' );
      error_log( "Dataset ".$tmpDataset );
      return $tmpDataset;
    }

    function getUserCount() {
      $tmpDataset = $this->CONN->querySingle( 'SELECT COUNT(*) as count FROM users' );
      return $tmpDataset;
    }

    function getUserList() {
      $tmpDataset = $this->CONN->query( 'SELECT * FROM users' );
      $tmpDataArray = [];
      while( $tmpResult = $tmpDataset->fetchArray()) {
        array_push($tmpDataArray, $tmpResult );
      }
      return $tmpDataArray;
    }

    function getTypeCount( $tmpType = "pdf" ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT COUNT(*) as count FROM books WHERE type="'.$tmpType.'"' );
      return $tmpDataset;
    }

    function getTagCount() {
      $tmpDataset = $this->CONN->querySingle( 'SELECT COUNT(*) as count FROM tags' );
      return $tmpDataset;
    }

    function getTagList() {
      $tmpDataset = $this->CONN->query( 'SELECT * FROM tags ORDER BY caption' );
      $tmpDataArray = [];
      while( $tmpResult = $tmpDataset->fetchArray()) {
        array_push($tmpDataArray, $tmpResult );
      }
      return $tmpDataArray;
    }

    function getTagName( $tmpTagNumber ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT caption FROM tags WHERE id='.$tmpTagNumber );
      return $tmpDataset;
    }

    function getTagsFor( $tmpID ) {
      $tmpDataset = $this->CONN->query( 'SELECT tag FROM tags2books WHERE book='.$tmpID );
      $tmpDataArray = [];
      while( $tmpResult = $tmpDataset->fetchArray()) {
        array_push($tmpDataArray, $this->getTagName( $tmpResult['tag'] ) );
      }
      return $tmpDataArray;
    }

    function setTagCaption( $tmpID, $tmpCaption ) {
      return $this->CONN->exec( 'UPDATE tags SET caption="'.$tmpCaption.'" WHERE id='.$tmpID );
    }

    function eraseTagFromDB( $tmpID ) {
      return $this->CONN->exec('DELETE FROM tags WHERE id="'.$tmpID.'"') | $this->CONN->exec('DELETE FROM tags2books WHERE tag="'.$tmpID.'"');
    }

    function setNewBook( $tmpUUID, $tmpName, $tmpType, $tmpUploader ) {
      return $this->CONN->exec('INSERT INTO books (uuid, title, type, uploader) VALUES ("'.$tmpUUID.'", "'.$tmpName.'", "'.$tmpType.'", "'.$tmpUploader.'" )');
    }

    function getBookCount() {
      $tmpDataset = $this->CONN->querySingle( 'SELECT COUNT(*) as count FROM books' );
      return $tmpDataset;
    }

    function getBookList( $tmpType="", $tmpSearchTerm="", $tmpTag="" ) {
        $tmpBaseSearch = "SELECT * FROM books ";
        $tmpBaseSearch.= ($tmpTag<>"")?"INNER JOIN tags2books ON tags2books.book=books.id ":"";
        //SELECT * FROM books INNER JOIN tags2books ON tags2books.book=books.id WHERE books.title LIKE "%dumm%" AND books.type="epub" AND tag="1"
        $tmpBaseArray = [];
        if ( $tmpTag<>"" ) { $tmpBaseArray[] = "tag='".$tmpTag."'"; }
        if ( $tmpType<>"" ) { $tmpBaseArray[] = "type='".$tmpType."'"; }
        if ( $tmpSearchTerm<>"" ) { $tmpBaseArray[] = "title LIKE '%".$tmpSearchTerm."%'"; }
        $tmpBaseSearch.=((count($tmpBaseArray)>0)?"WHERE ":"").implode(" AND ", $tmpBaseArray);

      error_log("Searching for...".$tmpBaseSearch);
      $tmpDataset = $this->CONN->query( $tmpBaseSearch );
      $tmpDataArray = [];
      while( $tmpResult = $tmpDataset->fetchArray()) {
        array_push($tmpDataArray, $tmpResult );
      }

      return $tmpDataArray;
    }

    function bookHasCover( $tmpUUID ) {
      error_log( "Searching in ".getcwd()." for ".$tmpUUID.".jpg");
      return file_exists( 'data/covers/'.$tmpUUID.'.jpg' );
    }

    function getBookUUID( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT uuid FROM books WHERE id="'.$tmpID.'"' );
      return $tmpDataset;
    }

    function getBookISBN( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT isbn FROM books WHERE id="'.$tmpID.'"' );
      return $tmpDataset;
    }

    function getBookTitle( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT title FROM books WHERE id="'.$tmpID.'"' );
      return $tmpDataset;
    }

    function getBookSummary( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT summary FROM books WHERE id="'.$tmpID.'"' );
      return $tmpDataset;
    }

    function getBookAuthor( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT author FROM books WHERE id="'.$tmpID.'"' );
      return $tmpDataset;
    }

    function getBookType( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT type FROM books WHERE id="'.$tmpID.'"' );
      return strtolower($tmpDataset);
    }

    function getBookUploader( $tmpID ) {
      $tmpDataset = $this->CONN->querySingle( 'SELECT uploader FROM books WHERE id="'.$tmpID.'"' );
      return strtolower($tmpDataset);
    }

  }

  class UUID {

    // This class is taken from https://www.php.net/manual/en/function.uniqid.php out of a commentary from Andrew Moore.
    // The class generates VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 3, 4 and 5

    public static function v3($namespace, $name) {

      if(!self::is_valid($namespace)) return false;

      // Get hexadecimal components of namespace
      $nhex = str_replace(array('-','{','}'), '', $namespace);

      // Binary Value
      $nstr = '';

      // Convert Namespace UUID to bits
      for($i = 0; $i < strlen($nhex); $i+=2) {
        $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
      }

      // Calculate hash value
      $hash = md5($nstr . $name);

      return sprintf('%08s-%04s-%04x-%04x-%12s',

        // 32 bits for "time_low"
        substr($hash, 0, 8),

        // 16 bits for "time_mid"
        substr($hash, 8, 4),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 3
        (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

        // 48 bits for "node"
        substr($hash, 20, 12)
      );
    }

    public static function v4() {

      return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
      );
    }

    public static function v5($namespace, $name) {

      if(!self::is_valid($namespace)) return false;

      // Get hexadecimal components of namespace
      $nhex = str_replace(array('-','{','}'), '', $namespace);

      // Binary Value
      $nstr = '';

      // Convert Namespace UUID to bits
      for($i = 0; $i < strlen($nhex); $i+=2) {
        $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
      }

      // Calculate hash value
      $hash = sha1($nstr . $name);

      return sprintf('%08s-%04s-%04x-%04x-%12s',

        // 32 bits for "time_low"
        substr($hash, 0, 8),

        // 16 bits for "time_mid"
        substr($hash, 8, 4),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 5
        (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

        // 48 bits for "node"
        substr($hash, 20, 12)
      );
    }

    public static function is_valid($uuid) {

      return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                        '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
  }

?>
