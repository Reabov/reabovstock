<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
	

	$db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
    $Elem = mysqli_fetch_array($db_element);
	
        ?>
	 
        <div class="content-wrapper">
			<section class="content-header">
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>
                
                <div class="both"></div>
				<div>
					<? 
					

					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        $active = checkboxParam('active');
						foreach ($Admin->ar_lang as $key => $value) { 
				            $exceptions[]='cpu_'.$value;
				        }

						$array=array();
						$array['active']=$active;				
						
						
						if($ar_clean['tags']){
							$exceptions[] = 'tags';
						}
						$exceptions[] = 'oldimg';
						
						$exceptions[] = 'col_list';
						
						include_once($_SERVER['DOCUMENT_ROOT'] . '/' . WS_PANEL . '/include/CImage.php');
						$CImage = new CImage();
						
						
						if( isset( $_FILES['image']['tmp_name'] ) && $_FILES['image']['tmp_name'] != '' ) {

                            $FileName = file_name( 10 , $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"] . $_params['image'] . $FileName;
                            $tempPathImage = $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $FileName;

                            $imginfo = getimagesize( $_FILES['image']['tmp_name'] );
                            if(!$imginfo){
                                echo('Image format error');
                            } else {
                                // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                                $rmuf = move_uploaded_file( $_FILES['image']['tmp_name'], $tempPathImage );
                                if( $rmuf ) {

                                    $params_image = array();
                                    // $params_image['canvas'] = true; // белый холст // http://kartinki.moy.su/1/7/foto_smeshnye_belki.jpg

                                    /*
                                    $params_image['watermark'] = array(
                                        'path' => '/desk2021path/templates/lte/dist/img/file_delete.png' ,  // полный путь с названием картинки
                                        'position' => 'top_left' , // ( опции - top_left , bottom_left , top_right , bottom_right , center ) , по умолчанию - center
                                        'coef_size' => 0.55 ,  // размер водяного знака относительно нашего изображения ( > 0 && < 1 )
                                    );
                                    */

                                    //$params_image['cropped_mode'] = 'center'; // center если хотим обрезать изображение по центру (если mode = cropped)
                                    $params_image['save_original_image'] = true; // если вы задали ресайз по высоте или ширине но изображение меньше тогда просто сохраним (ожидает true)
                                    $params_image['width'] = $_params['image_width'];
                                    $params_image['height'] = $_params['image_height'];
                                    $params_image['mode'] = 'resize'; // resize , cropped
                                    $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                                    if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }
                                    unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);

                                } else {
                                    echo '<br> Ошибка: файл не был загружен <br>';
                                }
                            }

                        }else{
                            $FileName = $ar_clean['oldimg'];
                        }

						updateElement($id, $_params['table'],array('active'=>$active,'image'=>$FileName), $array, $txt, $exceptions);
						
						$col = explode(',', $ar_clean['col_list']);
						
						mysqli_query($db, "DELETE FROM `ws_collections_products` WHERE product_id = '".$id."' ");
						if($ar_clean['col_list'] != ''){
							foreach ($col as $key => $col_id) {
								$insert = $Db->q("INSERT INTO `ws_collections_products` (elem_id, product_id) VALUES ('".$col_id."', '".$id."') ");
							}
						}
						
						
						foreach( $Admin->ar_lang as $lang_index ){
				                // ЧПУ
				                $arrURL[$lang_index] = $_POST['cpu_'.$lang_index];
				                if($arrURL[$lang_index]==''){
				                    $arrURL[$lang_index] = $_POST['title_'.$lang_index];
				                }
				         }
				         $arrURL = $CCpu->controlURL($arrURL); 
						 $arrURL = $CCpu->regionURL($arrURL); 
						 $addCpu = $CCpu->updateElementCpu($arrURL, $_params['page_id'],  $id);
						
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);
					
					$CPUs = array();
                    $getCPUs = mysqli_query($db," SELECT * FROM ws_cpu WHERE page_id = ".$_params['page_id']." AND elem_id = ".$id);
                    while($Cp = mysqli_fetch_assoc($getCPUs)){
                        $CPUs[$Cp['lang']] = $Cp['cpu'];
                    }
                   /*
                    if($ar_clean['tags']){
						mysqli_query ($db, "DELETE FROM `ws_catalog_element_tag` WHERE elem_id = ".$id);
						foreach ($ar_clean['tags'] as $tag_id) {								
							mysqli_query ($db, "INSERT INTO `ws_catalog_element_tag` (elem_id, tag_id) VALUES ('".$id."', '".$tag_id."') ");
						}
				    
					} 
				    * */
					?>
				    
				</div>
				
				<h1><?=$ParentElem['title_'.$Admin->lang]?> - <i><?=$Elem['title_'.$Admin->lang]?></i></h1>
			</section>
			<style>
				.sel {
					font-weight: 600;
				}
				.multi_select {
					border: solid thin #000;
    				max-height: 150px;
    				overflow-y: scroll;
    				padding: 0;
				}
				.multi_option {
					display: block;
					padding: 0 10px;
				}
				.multi_option label {
					width: 100%;
					font-weight: 400;
				}
				.multi_option.sel label {
					font-weight: 600;
				}
			</style>
			<section class="content">

				<div class="row">
					<div class="col-xs-12">
						<div class="">
							<form method="post" enctype="multipart/form-data">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?=$GLOBALS['CPLANG']['ALLADATA']?></a></li>
									<?
									$cur_tab = 2;
									foreach( $Admin->langs as $lang_index =>$Language ){
				                        ?>
				                        <li class=""><a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false"><?=$Language['title']?></a></li>
				                        <?
				                        $cur_tab++;
										
				                    }
									?>	
									 <li class="">
                                        <a href="#tab_10" data-toggle="tab" aria-expanded="false">
                                            <?=$GLOBALS['CPLANG']['PAGE_PHOTOGALLERY']?>
                                        </a>
                                    </li>						
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<div class="form-group">
                                            <label class="col-sm-3">Variations </label>
                                            <div class="col-sm-2">
                                                <select name="type" class="form-control input-sm">
                                                  	<option value="0" <?if($Elem['type']=='0'){?>selected<?}?>> Standart </option>
                                                  	<option value="1" <?if($Elem['type']=='1'){?>selected<?}?>> Extend </option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        <input required name="section_id" value="<?=$Elem['section_id']?>" hidden >
                                        <div class="form-group">
                                            <label class="col-sm-3">Категории </label>
                                            <div class="col-sm-2">
                                            	<ul class="multi_cat multi_select">
                                            		<?
                                            		$sections_arr = explode(',', $Elem['section_id']);
                                                  	$categories = $Db->getall("SELECT * FROM `ws_categories` WHERE active = 1 ");
                                            		foreach ($categories as $key => $cat) {
                                            			$sel = "";
														$check = "";
														if(in_array($cat['id'], $sections_arr)){
															$sel = "sel";
															$check = "checked";
														}
                                            			?>
                                            		<li class="multi_option <?=$sel?>" data-value="<?=$cat['id']?>">
                                            			<label for="cat_<?=$cat['id']?>" >
                                            				<input id="cat_<?=$cat['id']?>" <?=$check?> type="checkbox">
                                            				<?=$cat['title_'.$Admin->lang]?>
                                            			</label>
                                            		</li>
                                            			<?
                                            		}
                                            		?>
                                            	</ul>
                                            </div>
                                        </div>
                                        
                                        
                                        <?
                                        $col_arr = array();
                                        $check_col = $Db->getall("SELECT * FROM `ws_collections_products` WHERE product_id = ".$id);
										foreach ($check_col as $key => $value) {
											$col_arr[] = $value['elem_id'];
										}
										$tot_col = implode(',',$col_arr);
                                        $categories = $Db->getall("SELECT * FROM `ws_collections` WHERE active = 1 ");
                                        ?>
                                        <input required name="col_list" value="<?=$tot_col?>" hidden >
                                        <div class="form-group">
                                            <label class="col-sm-3">Коллекции </label>
                                            <div class="col-sm-2">
                                            	<ul class="multi_col multi_select">
                                            		<?
                                            		
                                            		foreach ($categories as $key => $cat) {
                                            			$sel = "";
														$check = "";
														if(in_array($cat['id'], $col_arr)){
															$sel = "sel";
															$check = "checked";
														}
                                            			?>
                                            		<li class="multi_option <?=$sel?>" data-value="<?=$cat['id']?>">
                                            			<label for="col_<?=$cat['id']?>" >
                                            				<input id="col_<?=$cat['id']?>" <?=$check?> type="checkbox">
                                            				<?=$cat['title_'.$Admin->lang]?>
                                            			</label>
                                            		</li>
                                            			<?
                                            		}
                                            		?>
                                            	</ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
										<div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ('.$_params['image_width'].' X '.$_params['image_height'].')', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
										<? editElem('format', 'Format', '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    <? editElem('sort', 'Sort', '1', $Elem,  '', 'edit', 1, 2 ); ?>
									</div>

									<?
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">
					                    	<?// editElem('h1', 'h1', '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        <? editElem('title', $GLOBALS['CPLANG']['TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        <? editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        <div class="form-group">
					                            <label for="exampleInputEmail1" class="col-sm-3">
					                            	<?=$GLOBALS['CPLANG']['PAGE_ADDR']?> (<span style="text-transform: uppercase"><?=$lang_index?></span>):</font> 
				                            	</label>
					                            <div class="col-sm-7">
					                            	<input  type="text" name="cpu_<?=$lang_index?>" value="<?=$CPUs[$lang_index]?>" class="form-control">
					                            </div>
					                        </div>
					                        <? editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAD'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
                                            <? editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAK'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
                                            
					                        <? editElem('text', "Description", '8', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        
					                        <? //editElem('link', 'Download link', '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        
					                    </div>
					                    
					                 <?}?>
					                                                  
									<div class="tab-pane" id="tab_10">
                                        <?
                                            /*галерея*/
                                            include($_SERVER['DOCUMENT_ROOT'] . "/" . WS_PANEL . "/lib/include/gallery.php");
                                        ?>
                                    </div>
								</div>
            				</div>
            				
            				<div style="text-align: center">
								<input onclick="check_required_col_cat()" type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
							</div>
							
            			</form>
					</div>
				</div>
			</div>
		</section>
	</div>
              
            <?
        
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>

<script>
	function check_required_col_cat(){
		var s = $('input[name="section_id"]').val();
		var c = $('input[name="col_list"]').val();
		if(s == '' && c == ''){
			alert('Выберите коллекцию или категории');
			return false;
		}
	}
	function check_required_new(){
		var has_prod = 0;
		var has_col = 0;
		
		var section = [];
		var col = [];
		$('.multi_cat input').each(function(){
			var id = $(this).parent().parent().data('value');
			var check = $(this).prop('checked');
			if(check){
				has_prod = 1;
				section.push(id);
			}
		})
		$('.multi_col input').each(function(){
			var id = $(this).parent().parent().data('value');
			var check = $(this).prop('checked');
			if(check){
				has_col = 1;
				col.push(id);
			}
		})
		var section_str = section.toString();
		var col_str = col.toString();
		$('input[name="section_id"]').val(section_str);
		$('input[name="col_list"]').val(col_str);
		
		
		if(has_prod){
			$('input[name="col_list"]').prop('required',false);
		}else{
			$('input[name="col_list"]').prop('required',true);
		}
		if(has_col){
			$('input[name="section_id"]').prop('required',false);
		}else{
			$('input[name="section_id"]').prop('required',true);
		}
		
	}
	
	$('.multi_cat input').on('click',function(){
		var parent = $(this).parent().parent();
		var label = $(this).parent();
		
		if( $(this).prop('checked') ){
			parent.addClass('sel');
		}else{
			parent.removeClass('sel');
		}
		
		check_required_new();
	})
	$('.multi_col input').on('click',function(){
		var parent = $(this).parent().parent();
		var label = $(this).parent();
		
		if( $(this).prop('checked') ){
			parent.addClass('sel');
		}else{
			parent.removeClass('sel');
		}
		
		check_required_new();
	})
	
	
	
	
	
	
	
	
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