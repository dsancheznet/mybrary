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
              }, 1000);

              alert('Upload Completed');
          }

      });

}


/*
$(document).ready(function() {
	// Setup html5 version
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,html4',

		// Fake server response here
		// url : '../upload.php',
		url: "/echo/json",

		max_file_size : '500mb',
		chunks : {
			size: '1mb',
			send_chunk_number: false // set this to true, to send chunk and total chunk numbers instead of offset and total bytes
		},
		rename : true,
		dragdrop: true,
		filters : [
    {title : "PDF files", extensions : "pdf"},
    {title : "ePub files", extensions : "epub"},
    {title : "Markdown files", extensions : "md"},
		{title : "Plain Text files", extensions : "txt"}
		],

		// Resize images on clientside if we can
		resize : {width : 320, height : 240, quality : 90},

		flash_swf_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/flash/Moxie.cdn.swf',
		silverlight_xap_url : 'http://rawgithub.com/moxiecode/moxie/master/bin/silverlight/Moxie.cdn.xap'
	});
});
*/








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
