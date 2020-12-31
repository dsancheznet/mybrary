// GENERAL PAGE PREPARATIONS

function PopulatePage() {
  ReloadSection("side-tags", "sidetags.php");
  ReloadSection("book-list", "booklist.php");
  ReloadSection("info-table", "infotable.php");
  ReloadSection("search-bar", "searchbar.php");
  //setTimeout(function(){ OverrideSubmit() }, 2000);
}

  function OverrideSubmit() {
    // Attach the event handler to the form element
    document.getElementById("search-form").addEventListener('submit', e => {
      event.preventDefault();
      document.getElementById("search-active").hidden = false;
      document.getElementById("search-term").innerHTML = document.getElementById("search-field").value;
      ReloadSection("book-list", "booklist.php", "search="+document.getElementById("search-term").innerHTML);
      ReloadSection("search-bar", "searchbar.php", "search="+document.getElementById("search-term").innerHTML);
      document.getElementById("search-field").value="";
      //UIkit.toggle(document.getElementById('search-modal')).toggle();
      alert('done');
        });//.{ once: true }
  }


// PERSONAL INFO FUNCTIONS

function ShowPersonalInfoForm( tmpName ) {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "lib/persinfo.php?nm="+tmpName, true);
  xhr.send();
}

function ShowUserAdminForm() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "lib/users.php", true);
  xhr.send();
}

function AvatarChanged() {
    document.getElementById("avatar-image").src = 'img/avatars/'+document.getElementById("avatar-selector").value
}

function SaveUserData() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
    }
  };
}


// UPLOAD FUNCTIONS

function ShowUploadForm() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "lib/upload.php", true);
  xhr.send();
}


// TAGS functions

function ShowTagAdminForm() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "lib/tags.php", true);
  xhr.send();
}

function EditTag( tagID, tagCaption ) {
  let xhr = new XMLHttpRequest();
  var newCaption = prompt("Edit Tag "+tagID , tagCaption );
  if ( newCaption == null ) {
    return;
  } else {
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if ( this.responseText == "error" ) {
          alert('Unknown Error.');
        } else {
          ReloadSection("side-tags", "sidetags.php");
          ShowTagAdminForm();
        }
      }
    };
    xhr.open("POST", "lib/edittag.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("function=edit&id="+tagID+"&caption="+newCaption);
  }
}

function DeleteTag( tagID, tagCaption ) {
  let xhr = new XMLHttpRequest();
  if (confirm("Sure you want to delete '"+tagCaption+"' and all of it's references?")) {
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if ( this.responseText == "error" ) {
          alert('Unknown Error.');
        } else {
          ReloadSection("side-tags", "sidetags.php");
          ShowTagAdminForm();
        }
      }
    };
    xhr.open("POST", "lib/edittag.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("function=delete&id="+tagID+"&caption="+tagCaption);
  } else {
    return;
  }
}


// BOOK FUNCTIONS

function ResetFilters() {
  document.getElementById("tag-filter").value="";
  document.getElementById("type-filter").value="";
  ReloadSection("book-list", "booklist.php");
  ResetSearchTerm();
}


// SEARCH FINCTIONS

function ResetSearchTerm() {
  document.getElementById('search-active').hidden = true;
  document.getElementById("search-term").value="";
  ReloadSection("book-list", "booklist.php");
}


function ShowSearch() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
      document.getElementById("search-field").focus();
    }
  };
  xhr.open("GET", "lib/searchpanel.php", true);
  xhr.send();
}

function CloseAndSendSearch() {
  if (document.getElementById('search-field').value!="") {
    document.getElementById('search-active').hidden = false;
    document.getElementById('search-term').innerHTML = document.getElementById('search-field').value;
    ReloadSection("book-list", "booklist.php");
  }
  UIkit.toggle(document.getElementById('modal-dash')).toggle();
}


// GENERAL FUNCTIONS

function ReloadSection( sectionID, sectionPHP, postParameters="" ) {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(sectionID).innerHTML = this.responseText;
    }
  };
  if ( postParameters == "" ) {
    xhr.open("GET", "lib/"+sectionPHP, true);
    xhr.send();
  } else {
    xhr.open("POST", "lib/"+sectionPHP, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send( postParameters );
  }
}
