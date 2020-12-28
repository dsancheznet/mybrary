<?php
  if ($_POST['search']<>"") {
    echo '<div class="uk-navbar-left"><a uk-icon="icon: trash" onclick="ResetSearchTerm()"></a>&ensp;<b>Search Term:</b>&ensp; <i>'.$_POST['search'].'</i></div>';
  }
?>
					<div class="uk-navbar-right">
			        <a id="search-modal" class="uk-navbar-toggle" href="#modal-full" uk-search-icon uk-toggle "></a>
			    </div>

					<div id="modal-full" class="uk-modal-full uk-modal" uk-modal>
					    <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
					        <button class="uk-modal-close-full" type="button" uk-close></button>
					        <form id="search-form" class="uk-search uk-search-large" onsubmit="OverrideSubmit()">
					            <input id="search-field" class="uk-search-input uk-text-center" type="search" placeholder="Search..." autofocus>
                      <script>
                       $("#search-field").on('keyup', function (event) {
                          if (event.keyCode === 13) {
                              document.getElementById("search-filter").value=document.getElementById("search-field").value;
                              UIkit.toggle(document.getElementById('search-modal')).toggle();
                              ReloadSection("book-list", "booklist.php", "search="+document.getElementById("search-filter").value);
                              ReloadSection("search-bar", "searchbar.php", "search="+document.getElementById("search-filter").value);
                              document.getElementById("search-field").value="";
                          }
                       });
                    </script>
					        </form>
					    </div>
					</div>
