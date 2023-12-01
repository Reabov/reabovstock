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
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php?section_id=<?=$_GET['section_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
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
                                    	<input type="hidden" name="section_id" value="<?=$_GET['section_id']?>"/>
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
                                <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
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



