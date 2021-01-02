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

  if ( intdiv( (int)$tmpUserRole & (int)2, 2) ) { //Do we have write privileges?
    //YES
    if (isset($_POST['bookid'])) { //Do we have a valid bookid?
      //YES
      //...continue in (almost) pure HTML
?>

<button class="uk-modal-close-default" type="button" uk-close></button>
<div id="save-message" class="uk-alert-success" uk-alert hidden>
  <a class="uk-alert-close" uk-close></a>
  <p id="save-paragraph">
  </p>
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
        <input id="bookform-isbn" class="uk-input" value="<?php echo $myDB->getBookISBN($_POST['bookid']);?>" pattern="[0-9]{13}">
    </div>
</div>


<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-select">Tags</label>
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: tag"></span>
        <input id="bookform-tags" class="uk-input" value="<?php //echo $myDB->getBookTagString($_POST['bookid']);?>">
    </div>
</div>

<button class="uk-button uk-button-primary uk-width-1-1 uk-margin-remove-bottom uk-margin-top" onclick="SaveBookData(<?php echo $_POST['bookid'];?>)"><span class="uk-margin-small-right" uk-icon="download"></span>Save</button>

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
