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
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php?elem_id=<?=$Elem['var_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>

                <div class="both"></div>

				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        $active = checkboxParam('active');
						$array = array();
						$array['active'] = $active;
                        $exceptions[] = 'oldimg';
						
						// Изображение            
				        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
							$uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
							$tempPathImage = $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $FileName;
                            
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }else{
								// загружаем нашу картинку а потом передаём в библиотеку путь до нее
                                $rmuf = move_uploaded_file( $_FILES['image']['tmp_name'], $tempPathImage );
                                if( $rmuf ) {
                                    $params_image = array();
                                    
                                    $params_image['width'] = $_params['image_width'];
                                    $params_image['height'] = $_params['image_height'];
                                    $params_image['mode'] = 'resize'; // resize , cropped
                                    $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                                    if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }
                                } else {
                                    echo '<br> Ошибка: файл не был загружен <br>';
                                }
                            }
							
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);                          							
                            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }
						$array['image']=$FileName;
                        
						
                        

                        updateElement($id, $_params['table'], $array , $txt, array(), $exceptions);
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);
					?>
				</div>
				
				<h1>
                    <i>
                        <?=$Elem['title_'.$Admin->lang]?>
                    </i>
                </h1>
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
                                    /*
									$cur_tab = 2;
									foreach( $Admin->langs as $lang_index =>$Language ){
				                        ?>
				                        <li class=""><a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false"><?=$Language['title']?></a></li>
				                        <?
				                        $cur_tab++;
				                    }*/
									?>
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
										 <?
                                        $c_tab = 2;
                                        foreach( $Admin->ar_lang as $lang_index ){  
                                            editElem('title', $GLOBALS['CPLANG']['TITLE']." (".$lang_index.")", '1', $Elem,  $lang_index, 'edit', 1, 7 );
                                        }?>
										
										
					                    <? //editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    
                                        <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ('.$_params['image_width'].'px *'.$_params['image_height'].'px)', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    <? //editElem('main_page', "Вывести на главной", '3', $Elem, '', 'edit' ); ?>

					                    <? //editElem('date', $GLOBALS['CPLANG']['DATE'], '6', $Elem, '', 'edit' ); ?>
					                    <? editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    
					                    <? editElem('link_en', 'Download link', '1', $Elem, '', 'edit', 1, 7 ); ?>
					                    
									</div>
									
									<?/*
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">

                                            <div class="form-group">
                                                <label class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
                                                <div class="col-sm-10">
                                                    <img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image_'.$lang_index]?>" />
                                                    <input type="hidden" name="oldimg_<?=$lang_index?>" value="<?=$Elem['image_'.$lang_index]?>" />
                                                </div>
                                            </div>
                                            <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ('.$_params['image_width'].'X'.$_params['image_height'].'px)', '5', $Elem,  $lang_index , 'edit', 0, 6, '', ''); ?>

                                            <div class="form-group">
                                                <label class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?> (mobile)</label>
                                                <div class="col-sm-10">
                                                    <img style="max-width: 300px;" src="<?=$_params['image_mobile'].$Elem['image_mobile_'.$lang_index]?>" />
                                                    <input type="hidden" name="oldimg_mobile_<?=$lang_index?>" value="<?=$Elem['image_mobile_'.$lang_index]?>" />
                                                </div>
                                            </div>
                                            <? editElem('image_mobile', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' ('.$_params['image_width_mobile'].'X'.$_params['image_height_mobile'].'px)', '5', $Elem,  $lang_index , 'edit', 0, 6, '', ''); ?>


                                            <? editElem('title', $GLOBALS['CPLANG']['TITLE'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>

                                            <? editElem('sub_title',  $GLOBALS['CPLANG']['TITLE'] .' (2)', '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>

                                            <? editElem('link', 'Link' , '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>

					                        <?// editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>

					                        <?// editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
					                        <?// editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
					                        <?// editElem('preview', $GLOBALS['CPLANG']['PREVIEW'], '8', $Elem,  $lang_index, 'edit'); ?>
					                        <?// editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', $Elem,  $lang_index, 'edit'); ?>
					                    </div>
					                    
					                 <?}*/?>
									
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

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>