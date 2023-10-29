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
                <div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    //обработка запроса
                    if( isset( $_POST['ok'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
						$active= checkboxParam('active');
						foreach ($Admin->ar_lang as $key => $value) { 
				            $exceptions[]='cpu_'.$value;
				        }
						
						$array=array();
						$array['active']=$active;

						if($ar_clean['tags']){
							$exceptions[] = 'tags';
						}
						
						
						$exceptions[] = 'col_list';
						
                        // -----
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/' . WS_PANEL . '/include/CImage.php');
                        $CImage = new CImage();
                        // -----
                        
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

                                } else {
                                    echo '<br> Ошибка: файл не был загружен <br>';
                                }
                            }

                        }
                        addElement($_params['table'],array('active'=>$active,'image'=>$FileName), $array, $txt, $exceptions); 
                        
                        $id = mysqli_insert_id($db);
						
						$col = explode(',', $ar_clean['col_list']);
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
                         
						 
						/*
                        if($ar_clean['tags']){
							foreach ($ar_clean['tags'] as $tag_id) {
								mysqli_query ($db, "INSERT INTO `ws_catalog_element_tag` (elem_id, tag_id) VALUES ('".$id."', '".$tag_id."') ");
							}
						}
						 
						 */
						  // если добавляли фото в галлерею
                            if(isset($_SESSION['photo_gallery_add_page']) && !empty($_SESSION['photo_gallery_add_page'])) {
                                mysqli_query($db, " UPDATE `ws_photogallery` SET `elem_id` = '". $id ."' WHERE page_id = '". $_params['page_id'] ."' AND id IN (". implode(',', $_SESSION['photo_gallery_add_page']) .")  ");
                            }
                    }
                    ?>
                </div>
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
                        	<h4><?=$ParentElem['title_'.$Admin->lang]?></h4>
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
                                        $cur_tab++;}
                                    ?>
                                    <?/*<li class="">
                                        <a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false">
                                            <?=$GLOBALS['CPLANG']['PAGE_PHOTOGALLERY']?>
                                        </a>
                                    </li>*/?> <? $cur_tab++; ?>
                                </ul>
                                
                                <div class="tab-content form-horizontal">
                                    
                                    <div class="tab-pane active" id="tab_1">
                                    	<div class="form-group">
                                            <label class="col-sm-3">Variations </label>
                                            <div class="col-sm-2">
                                                <select name="type" class="form-control input-sm">
                                                  	<option value="0"> Standart </option>
                                                  	<option value="1"> Extend </option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        <input required name="section_id" value="<?=$Elem['section_id']?>" hidden >
                                        <div class="form-group">
                                            <label class="col-sm-3">Категории </label>
                                            <div class="col-sm-2">
                                            	<ul class="multi_cat multi_select">
                                            		<?
                                                  	$categories = $Db->getall("SELECT * FROM `ws_categories` WHERE active = 1 ");
                                            		foreach ($categories as $key => $cat) {
                                            			?>
                                            		<li class="multi_option" data-value="<?=$cat['id']?>">
                                            			<label for="cat_<?=$cat['id']?>" >
                                            				<input id="cat_<?=$cat['id']?>" type="checkbox">
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
                                        $categories = $Db->getall("SELECT * FROM `ws_collections` WHERE active = 1 ");
                                        ?>
                                        <input required name="col_list" value="" hidden >
                                        <div class="form-group">
                                            <label class="col-sm-3">Коллекции </label>
                                            <div class="col-sm-2">
                                            	<ul class="multi_col multi_select">
                                            		<?
                                            		foreach ($categories as $key => $cat) {
                                            			?>
                                            		<li class="multi_option" data-value="<?=$cat['id']?>">
                                            			<label for="col_<?=$cat['id']?>" >
                                            				<input id="col_<?=$cat['id']?>" type="checkbox">
                                            				<?=$cat['title_'.$Admin->lang]?>
                                            			</label>
                                            		</li>
                                            			<?
                                            		}
                                            		?>
                                            	</ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    	
                                    	<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'add', '', 2,'','',1); ?>
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ('.$_params['image_width'].' X '.$_params['image_height'].')', '5', $Elem,  '', 'add', 1, 6, '', ''); ?>
										<? editElem('format', 'Format', '1', $Elem,  '', 'add', 1, 2 ); ?>
                                        <? editElem('sort', 'sort', '1', '',  '', 'add', 1, 2,'','',500); ?>
                                    </div>
                                    <?
                                    $c_tab = 2;
                                    foreach( $Admin->ar_lang as $lang_index ){ 
                                        ?>
                                        <div class="tab-pane" id="tab_<?=$c_tab++?>">
                                        	
                                            <? editElem('title',  $GLOBALS['CPLANG']['TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <? editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <? editElem('cpu', $GLOBALS['CPLANG']['PAGE_ADDR'], '1', '',  $lang_index, 'add', 0, 7 ); ?> 
                                            <? editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
											<? editElem('text', "Description", '8', $Elem,  $lang_index, 'add', 1, 7 ); ?>
											<? //editElem('link',  'Download link', '1', '',  $lang_index, 'add', 1, 7 ); ?>
											
                                        </div>
                                        <?
                                    }  
                                    ?>
                                    <?/* <div class="tab-pane" id="tab_<?=$c_tab?>">
                                        <?
                                        include($_SERVER['DOCUMENT_ROOT'] . "/" . WS_PANEL . "/lib/include/gallery.php");
                                        $c_tab++;
                                        ?>
                                    </div> */?>
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
</script>

