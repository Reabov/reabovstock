<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php"); 
	$db_element = mysqli_query($db, "SELECT * FROM `ws_categories` WHERE id='".$_GET['section_id']."'");
    $ParentElem = mysqli_fetch_assoc($db_element); 
?>
    
    <div class="content-wrapper">
			<section class="content-header">
				<h1><?=$_params['title']?> - <?=$ParentElem['title_'.$Admin->lang]?></h1>
				<div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="../list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$ParentElem['title_'.$Admin->lang]?>)</a>
                </div>
				
				<?/* <div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php?section_id=<?=$ParentElem['id']?>"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
             	</div> */?>
                <div class="both"></div>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
                            	<?/* <form method="get">
                                	<div class="row">
                                    	<div class="col-lg-4">
                                        	<input type="text" name="search" required class="form-control input-sm"/>
                                        	<?
                                        	foreach ($_GET as $key => $value) {
                                            	if($key=='search'){continue;}
                                            	?>
                                            	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                                            	<?
                                        	}
                                        	?>
                                    	</div>
                                    	<div class="col-lg-4 ">
                                        	<button type="submit" class="btn btn-primary btn-sm">
                                            	<i class="glyphicon glyphicon-search"></i> <?=$GLOBALS['CPLANG']['SEARCH_WORD']?>
                                        	</button>
                                        	<? if(isset($_GET['search']) && $_GET['search'] != '') { ?>
                                            	<div class="btn-group backbutton">
                                                	<a class="btn btn-block btn-info btn-xs" href="?"> <?=$GLOBALS['CPLANG']['GO_BACK']?></a>
                                            	</div>
                                        	<? } ?>
                                    	</div>
                                	</div>
                            	</form> */?>
                        	</div>
							
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-striped dataTable">
									<tr>
										<th width="30">ID</th>
								        <th><?=$GLOBALS['CPLANG']['TITLE']?></th>    
								        <th>Text</th> 
								        <th>Format</th> 
								          
								        <th ><?=$GLOBALS['CPLANG']['IMAGE']?></th>     
								          
								        
								        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									$where_cat = "  WHERE section_id = '$ParentElem[id]' OR section_id LIKE '$ParentElem[id],%' OR section_id LIKE '%,$ParentElem[id]' OR section_id LIKE '%,$ParentElem[id],%' ";
									$query = "SELECT id FROM `".$_params['table']."` $where_cat "; 
								    $Paginator = pagination($query, $_params['num_page']);

							      $subcatalog = mysqli_query($db,
							        "SELECT * FROM `".$_params['table']."` $where_cat  ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
								    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
								        $listAct = 'label-success';
                                        if($Elem['active']==0){
                                            $listAct = 'label-default';
                                        }
								        ?>
								        <tr class="<?if($Elem['active']==0){?>disabled<?}?>" >
								            <td align="center">
								                <?=$Elem['id']?>
							                </td>
								            <td>
								            	<b>
								            		<?=$Elem['title_'.$Admin->lang]?>
								            	</b> 
								            </td>
								            <td>
								            	<b>
								            		<?=$Elem['text_'.$Admin->lang]?>
								            	</b> 
								            </td>
								            <td>
								            	<b>
								            		<?=$Elem['format']?>
								            	</b> 
								            </td>
								            <td align="left">
				                            	<img style="max-width: 150px;" src="<?=$_params['image'].$Elem['image']?>" />                        
								            </td>
								            <td align="center" width="310">
												<div class="btn-group wgroup">
													<a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
							                			<i class="glyphicon glyphicon-refresh"></i>
							                		</a>
							                		<?
							                		/*if($Elem['type'] == '0'){
							                			?>
							                		<a href="size/list_elem.php?elem_id=<?=$Elem['id']?>" class="btn btn-default" title="Размеры">
							                			<i class="glyphicon glyphicon-comment" aria-hidden="true"></i>
							                		</a>
							                			<?
							                		}else{
							                			?>
							                		<a href="variations/list_elem.php?elem_id=<?=$Elem['id']?>" class="btn btn-default" title="Размеры">
							                			<i class="fa fa-folder"></i>
							                		</a>	
							                			<?
							                		}*/
							                		?>
							                		
							                		<?/* <a href="tags/list_elem.php?catalog_id=<?=$Elem['id']?>" class="btn btn-default" title="Тэги">
							                			<i class="fa fa-list"></i>
							                		</a> */?>
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>&cat_id=<?=$_GET['section_id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                		<?if( $User->InGroup($_params['access_delete'])  ):?>
							                		<a onclick="return confirm('<?=$GLOBALS['CPLANG']['SURE_TO_DELETE']?>')" href="delete_elem.php?id=<?=$Elem['id']?>" class="btn btn-default btn-danger">
                                                        <i class="glyphicon glyphicon-remove-circle wglyph"></i>
                                                    </a>
							                		<?endif;?>
							                	</div>
								            </td>
								        </tr>
								        <?
								    }
							        ?>
								</table>
							</div>
							
						</div>
					</div>
				</div>
                <?
                paginate($Paginator);  
                ?>
			</section>

		</div>

    
    <? 
    
    ?>  
      

    
    
    <? 
    
}
?>

<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>
<script>
	
	var id = <?=$_GET['catalog_id']?>;
	$.ajax({
        type: "POST",
        url: "/<?=WS_PANEL?>/ajax/",
        data: "task=get_article_codes&id="+id,
        success: function(msg){
        	//alert(typeof(msg));
             var article_codes = JSON.parse(msg);
             autocomplete(document.getElementById("myInput"), article_codes);
        }
    });
    
    function searchByArticleCode(){
    	var url = location.href;
    	var code = $('#myInput').val();
    	var index = location.href.indexOf("article_code");
    	if (index > -1) {
    		var removeThis = url.slice(index);
    		location.href = url.replace(removeThis, '') + 'article_code=' + code;
    		//alert(url.replace(removeThis, ''));
    	}else{
    		location.href = url + '&article_code=' + code;
    	}   	
    }
    
    function resetSearch() {
    	var url = location.href;
    	var index = location.href.indexOf("article_code");
    	var removeThis = url.slice(index - 1);
		location.href = url.replace(removeThis, '');
    }
    
	function triggerEnterButton(event) {
		// Number 13 is the "Enter" key on the keyboard
		 if (event.keyCode === 13) {
		    // Cancel the default action, if needed
		    event.preventDefault();
		    // Trigger the button element with a click
		    searchByArticleCode();
		  }
	}
	
	function autocomplete(inp, arr) {
	  /*the autocomplete function takes two arguments,
	  the text field element and an array of possible autocompleted values:*/
	  var currentFocus;
	  /*execute a function when someone writes in the text field:*/
	  inp.addEventListener("input", function(e) {
	      var a, b, i, val = this.value;
	      /*close any already open lists of autocompleted values*/
	      closeAllLists();
	      if (!val) { return false;}
	      currentFocus = -1;
	      /*create a DIV element that will contain the items (values):*/
	      a = document.createElement("DIV");
	      a.setAttribute("id", this.id + "autocomplete-list");
	      a.setAttribute("class", "autocomplete-items");
	      /*append the DIV element as a child of the autocomplete container:*/
	      this.parentNode.appendChild(a);
	      /*for each item in the array...*/
	      for (i = 0; i < arr.length; i++) {
	        /*check if the item starts with the same letters as the text field value:*/
	        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
	          /*create a DIV element for each matching element:*/
	          b = document.createElement("DIV");
	          /*make the matching letters bold:*/
	          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
	          b.innerHTML += arr[i].substr(val.length);
	          /*insert a input field that will hold the current array item's value:*/
	          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
	          /*execute a function when someone clicks on the item value (DIV element):*/
	              b.addEventListener("click", function(e) {
	              /*insert the value for the autocomplete text field:*/
	              inp.value = this.getElementsByTagName("input")[0].value;
	              /*close the list of autocompleted values,
	              (or any other open lists of autocompleted values:*/
	              closeAllLists();
	          });
	          a.appendChild(b);
	        }
	      }
	  });
	  /*execute a function presses a key on the keyboard:*/
	  inp.addEventListener("keydown", function(e) {
	      var x = document.getElementById(this.id + "autocomplete-list");
	      if (x) x = x.getElementsByTagName("div");
	      if (e.keyCode == 40) {
	        /*If the arrow DOWN key is pressed,
	        increase the currentFocus variable:*/
	        currentFocus++;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 38) { //up
	        /*If the arrow UP key is pressed,
	        decrease the currentFocus variable:*/
	        currentFocus--;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 13) {
	        /*If the ENTER key is pressed, prevent the form from being submitted,*/
	        e.preventDefault();
	        if (currentFocus > -1) {
	          /*and simulate a click on the "active" item:*/
	          if (x) x[currentFocus].click();
	        }
	      }
	  });
	  
	   /*execute a function when someone click on the text field:*/
	  inp.addEventListener("click", function(e) {
	      var a, b, i, val = this.value;
	      /*close any already open lists of autocompleted values*/
	      closeAllLists();
	      if (!val) { val = ''}
	      currentFocus = -1;
	      /*create a DIV element that will contain the items (values):*/
	      a = document.createElement("DIV");
	      a.setAttribute("id", this.id + "autocomplete-list");
	      a.setAttribute("class", "autocomplete-items");
	      /*append the DIV element as a child of the autocomplete container:*/
	      this.parentNode.appendChild(a);
	      /*for each item in the array...*/
	      for (i = 0; i < arr.length; i++) {
	        /*check if the item starts with the same letters as the text field value:*/
	        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
	          /*create a DIV element for each matching element:*/
	          b = document.createElement("DIV");
	          /*make the matching letters bold:*/
	          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
	          b.innerHTML += arr[i].substr(val.length);
	          /*insert a input field that will hold the current array item's value:*/
	          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
	          /*execute a function when someone clicks on the item value (DIV element):*/
	              b.addEventListener("click", function(e) {
	              /*insert the value for the autocomplete text field:*/
	              inp.value = this.getElementsByTagName("input")[0].value;
	              /*close the list of autocompleted values,
	              (or any other open lists of autocompleted values:*/
	              closeAllLists();
	              searchByArticleCode();
	          });
	          a.appendChild(b);
	        }
	      }
	  });
	  
	  function addActive(x) {
	    /*a function to classify an item as "active":*/
	    if (!x) return false;
	    /*start by removing the "active" class on all items:*/
	    removeActive(x);
	    if (currentFocus >= x.length) currentFocus = 0;
	    if (currentFocus < 0) currentFocus = (x.length - 1);
	    /*add class "autocomplete-active":*/
	    x[currentFocus].classList.add("autocomplete-active");
	  }
	  function removeActive(x) {
	    /*a function to remove the "active" class from all autocomplete items:*/
	    for (var i = 0; i < x.length; i++) {
	      x[i].classList.remove("autocomplete-active");
	    }
	  }
	  function closeAllLists(elmnt) {
	    /*close all autocomplete lists in the document,
	    except the one passed as an argument:*/
	    var x = document.getElementsByClassName("autocomplete-items");
	    for (var i = 0; i < x.length; i++) {
	      if (elmnt != x[i] && elmnt != inp) {
	      x[i].parentNode.removeChild(x[i]);
	    }
	  }
	}
	/*execute a function when someone clicks in the document:*/
	document.addEventListener("click", function (e) {
	    closeAllLists(e.target);
	});
	
	
</script>