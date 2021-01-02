/*
██ ███    ██ ██ ████████ 
██ ████   ██ ██    ██    
██ ██ ██  ██ ██    ██ 
██ ██  ██ ██ ██    ██ 
██ ██   ████ ██    ██ 
*/

function PopulatePage() {
  ReloadSection("side-tags", "sidetags.php");
  ReloadSection("book-list", "booklist.php");
  ReloadSection("info-table", "infotable.php");
  ReloadSection("search-bar", "searchbar.php");
  ReloadSection("side-library", "sidelibrary.php");
}

/*
██████  ███████ ██████  ███████  ██████  ███    ██  █████  ██ 
██   ██ ██      ██   ██ ██      ██    ██ ████   ██ ██   ██ ██ 
██████  █████   ██████  ███████ ██    ██ ██ ██  ██ ███████ ██ 
██      ██      ██   ██      ██ ██    ██ ██  ██ ██ ██   ██ ██ 
██      ███████ ██   ██ ███████  ██████  ██   ████ ██   ██ ███████
*/

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

/*
██    ██ ██████  ██       ██████   █████  ██████ 
██    ██ ██   ██ ██      ██    ██ ██   ██ ██   ██ 
██    ██ ██████  ██      ██    ██ ███████ ██   ██ 
██    ██ ██      ██      ██    ██ ██   ██ ██   ██ 
 ██████  ██      ███████  ██████  ██   ██ ██████ 
*/

function ShowUploadForm() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("modal-body").innerHTML = this.responseText;
      ConfigureUpload();
    }
  };
  xhr.open("GET", "lib/upload.php", true);
  xhr.send();
}


function ConfigureUpload() {
      var bar = document.getElementById('js-progressbar');
      UIkit.upload('.js-upload', {
          url: 'lib/chunk.php',
          multiple: true,
          beforeSend: function () {
              console.log('beforeSend', arguments);
          },
          beforeAll: function () {
              console.log('beforeAll', arguments);
          },
          load: function () {
              console.log('load', arguments);
          },
          error: function () {
              console.log('error', arguments);
          },
          complete: function () {
              console.log('complete', arguments);
          },
          loadStart: function (e) {
              console.log('loadStart', arguments);

              bar.removeAttribute('hidden');
              bar.max = e.total;
              bar.value = e.loaded;
          },
          progress: function (e) {
              console.log('progress', arguments);

              bar.max = e.total;
              bar.value = e.loaded;
          },
          loadEnd: function (e) {
              console.log('loadEnd', arguments);

              bar.max = e.total;
              bar.value = e.loaded;
          },
          completeAll: function () {
              console.log('completeAll', arguments);
              setTimeout(function () {
                  bar.setAttribute('hidden', 'hidden');
                  ReloadSection("side-tags", "sidetags.php");
                  ReloadSection("book-list", "booklist.php");
                  ReloadSection("info-table", "infotable.php");
                  ReloadSection("search-bar", "searchbar.php");
                  ReloadSection("side-library", "sidelibrary.php");
                  document.getElementById("result-panel").innerHTML = "ok";
              }, 1000);
          }

      });

}

/*
████████  █████   ██████  ███████ 
   ██    ██   ██ ██       ██      
   ██    ███████ ██   ███ ███████ 
   ██    ██   ██ ██    ██      ██ 
   ██    ██   ██  ██████  ███████ 
*/

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

function ReadAndCreateTag() {
  let xhr = new XMLHttpRequest();
  var tagCaption = prompt("Please enter new tag name...");
  if (tagCaption != null) {
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if ( this.responseText == "error" ) {
          alert('Unknown Error.');
        } else {
          ReloadSection("info-table", "infotable.php");
          ReloadSection("side-tags", "sidetags.php");
          ShowTagAdminForm();
      }
    }
  };
  xhr.open("POST", "lib/edittag.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("function=create&caption="+tagCaption);
  }
}

/*
██████   ██████   ██████  ██   ██ ███████ 
██   ██ ██    ██ ██    ██ ██  ██  ██      
██████  ██    ██ ██    ██ █████   ███████ 
██   ██ ██    ██ ██    ██ ██  ██       ██ 
██████   ██████   ██████  ██   ██ ███████ 
*/

function ResetFilters() {
  document.getElementById("tag-filter").value="";
  document.getElementById("type-filter").value="";
  ReloadSection("book-list", "booklist.php");
  ResetSearchTerm();
}

function DeleteBookWithId( bookID ) {
  let xhr = new XMLHttpRequest();
  if (confirm("Sure you want to delete this book?")) {
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if ( this.responseText == "error" ) {
          alert('Unknown Error.');
        } else {
          ReloadSection("info-table", "infotable.php");
          ReloadSection("book-list", "booklist.php");
          ReloadSection("side-library", "sidelibrary.php");
        }
      }
    };
    xhr.open("POST", "lib/delete.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("bookid="+bookID);
  } else {
    return;
  }
}

/*
███████ ███████  █████  ██████   ██████ ██   ██ 
██      ██      ██   ██ ██   ██ ██      ██   ██ 
███████ █████   ███████ ██████  ██      ███████ 
     ██ ██      ██   ██ ██   ██ ██      ██   ██ 
███████ ███████ ██   ██ ██   ██  ██████ ██   ██ 
*/

function ResetSearchTerm() {
  document.getElementById('search-active').hidden = true;
  document.getElementById("search-term").value="";
  document.getElementById("tag-filter").value="";
  document.getElementById("type-filter").value="";
  ReloadSection("book-list", "booklist.php");
}

function  RegisterTypeSearch( typeToSearch ) {
  document.getElementById('type-filter').value = typeToSearch;
  ExecuteSearch();
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
    ExecuteSearch();
  }
  UIkit.toggle(document.getElementById('modal-dash')).toggle();
}

function ExecuteSearch() {
  var postParameters = "";
  if ( document.getElementById('type-filter').value!="" ) {
   postParameters = "type="+document.getElementById('type-filter').value;
  }
  if ( document.getElementById('search-term').innerHTML!="" ) {
    if ( postParameters != "" ) { postParameters += "?search"+document.getElementById('search-term').innerHTML }
    else { postParameters = "search="+document.getElementById('search-term').innerHTML }
  }
  if ( document.getElementById('tag-filter').value!="" ) {
    if ( postParameters != "" ) { postParameters += "?tag"+document.getElementById('tag-filter').innerHTML }
    else { postParameters = "tag="+document.getElementById('tag-filter').value }
  }
  ReloadSection("book-list", "booklist.php", postParameters);
}

/*
 ██████  ███████ ███    ██ ███████ ██████   █████  ██ 
██       ██      ████   ██ ██      ██   ██ ██   ██ ██ 
██   ███ █████   ██ ██  ██ █████   ██████  ███████ ██ 
██    ██ ██      ██  ██ ██ ██      ██   ██ ██   ██ ██ 
 ██████  ███████ ██   ████ ███████ ██   ██ ██   ██ ███████ 
*/

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
