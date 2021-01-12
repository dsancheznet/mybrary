<?php
  include_once( 'user-functions.php' );
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

  if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) { //Do we have write privileges?
    //YES
    if (isset($_POST['bookid'])) { //Do we have a valid bookid?
      //YES
      //...continue in (almost) pure HTML
?>

<button class="uk-modal-close-default" type="button" uk-close></button>

<div id="save-message" class="uk-alert-warning" uk-alert hidden>
  <a class="uk-alert-close" uk-close></a>
  <p id="save-paragraph">
  </p>
</div>

<div class="js-upload uk-align-right uk-margin-small-top" uk-form-custom>
    <input type="file">
    <button id="cover-upload-button" class="uk-button uk-button-default" type="button" tabindex="-1">Add cover</button>
</div>

<div class="uk-align-right uk-margin-small-top" uk-form-custom>
    <button class="uk-button uk-button-default" type="button" tabindex="-1" onclick="RemoveCoverFromBook( <?php echo $_POST['bookid']; ?> )">Remove Cover</button>
</div>

<h4>· Book Data ·</h4>
<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">Title</label>
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: bookmark"></span>
        <input id="bookform-title" class="uk-input" value="<?php echo $myDB->getBookTitle($_POST['bookid']);?>">
    </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">Author</label>
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input id="bookform-author" class="uk-input" value="<?php echo $myDB->getBookAuthor($_POST['bookid']);?>">
    </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">Summary</label>
    <div class="uk-inline uk-width-1-1">
      <textarea id="bookform-summary" class="uk-textarea" rows="5" placeholder="Place a short summary here..."><?php echo $myDB->getBookSummary($_POST['bookid']);?></textarea>
    </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">ISBN</label>
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: social"></span>
        <input id="bookform-isbn" class="uk-input" value="<?php echo $myDB->getBookISBN($_POST['bookid']);?>" pattern="[0-9]{13}" onchange="RemoveDashesAndSpacesFrom( document.getElementById('bookform-isbn') )">
    </div>
</div>


<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">Tags</label>
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: tag"></span>
        <input id="bookform-tags" class="uk-input" value="<?php echo $myDB->getTagStringForBook($_POST['bookid']);?>">
    </div>
</div>

<button class="uk-button uk-button-primary uk-width-1-1 uk-margin-remove-bottom uk-margin-top" onclick="SaveBookData(<?php echo $_POST['bookid'];?>)" uk-toggle="target: #modal-dash"><span class="uk-margin-small-right" uk-icon="download"></span>Save</button>

<?php
    } else {
      echo "error: no bookid provided.";
      exit();
    }
  } else {
    echo "Access Denied. <br />";
    echo "You don't have write privileges.";
    exit();
  }
