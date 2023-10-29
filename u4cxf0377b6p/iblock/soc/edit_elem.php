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
				
                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        $active = checkboxParam('active');
						
				        foreach ($Admin->ar_lang as $key => $value) { 
				            
				        }
                        
				        $exceptions[] = 'oldimg';
				        $exceptions[] = 'oldimg_act';
				        
				        
				        
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
                                //echo('Image format error');
								$rmuf = move_uploaded_file( $_FILES['image']['tmp_name'], $uploadfile );
								if( $rmuf ) {
									unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
								}else{
									echo '<br> Ошибка: файл не был загружен <br>';
								}
                            } else {
                                // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                                $rmuf = move_uploaded_file( $_FILES['image']['tmp_name'], $tempPathImage );
                                if( $rmuf ) {
                                    $params_image = array();
                                    
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
						
						$CImage->clear();
						
						if( isset( $_FILES['image_act']['tmp_name'] ) && $_FILES['image_act']['tmp_name'] != '' ) {
                            $FileName2 = file_name( 10 , $_FILES['image_act']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"] . $_params['image'] . $FileName2;
                            $tempPathImage = $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $FileName2;

                            $imginfo = getimagesize( $_FILES['image_act']['tmp_name'] );
                            if(!$imginfo){
                                //echo('Image format error');
								$rmuf = move_uploaded_file( $_FILES['image_act']['tmp_name'], $uploadfile );
								if( $rmuf ) {
									unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg_act']);
								}else{
									echo '<br> Ошибка: файл не был загружен <br>';
								}
                            } else {
                                // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                                $rmuf = move_uploaded_file( $_FILES['image_act']['tmp_name'], $tempPathImage );
                                if( $rmuf ) {
                                    $params_image = array();
                                    
                                    $params_image['width'] = $_params['image_width'];
                                    $params_image['height'] = $_params['image_height'];
                                    $params_image['mode'] = 'resize'; // resize , cropped
                                    $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                                    if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }
                                    unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg_act']);
                                } else {
                                    echo '<br> Ошибка: файл не был загружен <br>';
                                }
                            }
                        }else{
                            $FileName2 = $ar_clean['oldimg_act'];
                        }
						
						

				        updateElement($id, $_params['table'], array(/* 'image'=>$FileName, */'image_act'=>$FileName2), $txt, array(), $exceptions);
                        
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);
                    
                    
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
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
					                    <? //editElem('main_page', "Вывести на главной", '3', $Elem, '', 'edit' ); ?>
					                    <?/*
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' 46X46 ', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    */?>
					                    
					                    
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE'].' (Activ)'?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image_act']?>" />  
				                            	<input type="hidden" name="oldimg_act" value="<?=$Elem['image_act']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image_act', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' 46X46 ', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    
					                    
									</div>
									
									<?
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">
					                        <? editElem('link', 'Link', '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                    </div>
					                 <?}?>
                                    
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