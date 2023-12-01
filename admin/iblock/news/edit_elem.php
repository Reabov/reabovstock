<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
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
				            $txt[]='text_'.$value;
				            $exceptions[]='cpu_'.$value;
				        }
                        
				        $exceptions[] = 'oldimg';
				        
				        
				        // Изображение
                        /* старый способ
				        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }*/

                        // -----
                        include_once( $_SERVER['DOCUMENT_ROOT'] . '/'. WS_PANEL .'/include/CImage.php' );
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

                                    // $params_image['cropped_mode'] = 'center'; // center если хотим обрезать изображение по центру (если mode = cropped)
                                    // $params_image['save_original_image'] = true; // если вы задали ресайз по высоте или ширине но изображение меньше тогда просто сохраним (ожидает true)
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

				        updateElement($id, $_params['table'], array('active'=>$active,'image'=>$FileName), $txt, array(), $exceptions);

                        if( $_params['page_id']>0 ){
                             foreach( $Admin->ar_lang as $lang_index ){
                                    // ЧПУ
                                    $arrURL[$lang_index] = $_POST['cpu_'.$lang_index];
                                    if($arrURL[$lang_index]==''){
                                        $arrURL[$lang_index] = $_POST['title_'.$lang_index];
                                    }
                             }
                             $arrURL = $CCpu->controlURL($arrURL);
                             $arrURL = $CCpu->regionURL($arrURL);
                             $addCpu = $CCpu->updateElementCpu($arrURL, $_params['page_id'], $id);
                        }

				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);

                    $CPUs = array();
                    $getCPUs = mysqli_query($db," SELECT * FROM ws_cpu WHERE page_id = ".$_params['page_id']." AND elem_id = ".$id);
                    while($Cp = mysqli_fetch_assoc($getCPUs)){
                        $CPUs[$Cp['lang']] = $Cp['cpu'];
                    }
                    
					?>
				</div>
				
				<h1><i><?=$Elem['title_'.$Admin->lang]?></i></h1>
			</section>

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
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
					                    <? //editElem('main_page', "Вывести на главной", '3', $Elem, '', 'edit' ); ?>
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    <? editElem('date', $GLOBALS['CPLANG']['DATE'], '6', $Elem, '', 'edit' ); ?>
					                    <? // editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>
									</div>
									
									<?
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">
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
					                        <? editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
					                        <? editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
					                        <? editElem('preview', $GLOBALS['CPLANG']['PREVIEW'], '8', $Elem,  $lang_index, 'edit'); ?>
					                        <? editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', $Elem,  $lang_index, 'edit'); ?>
					                    </div>
					                 <?}?>

                                    <div class="tab-pane" id="tab_10">
                                        <?
                                            /*галерея*/
                                            include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/lib/include/gallery.php");
                                        ?>
                                    </div>

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