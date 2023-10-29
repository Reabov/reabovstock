<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
	
	$db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
    $Elem = mysqli_fetch_assoc($db_element); 
	$final = $Elem['is_final']
        ?>
        <div class="content-wrapper">
			<section class="content-header">
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php?parent=<?=$Elem['section_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php?parent=<?=$parent?>"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>
                <div class="both"></div>
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS); 
				        $active = checkboxParam('active');
						$type= checkboxParam('type');
				        foreach ($Admin->ar_lang as $key => $value) { 
				            $txt[]='text_'.$value;
				            $exceptions[]='cpu_'.$value;
				        }
							
						$exceptions[] = 'oldimg';
						$exceptions[] = 'oldicon';
						
						// -----
                        include_once( $_SERVER['DOCUMENT_ROOT'] . '/'. WS_PANEL .'/include/CImage.php' );
                        $CImage = new CImage();
                        // -----
						
				        // Изображение      
				        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            $tempPathImage = $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $FileName;
                            
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }else{
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
							//createThumbnail($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height'], array(255,255,255));
							 //make_thumb($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							 
							 //move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
				             //unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }
						 // Изображение        
						$array=array('image'=>$FileName);
				        updateElement($id, $_params['table'], array('active'=>$active), $txt, $array, $exceptions);

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
										<?  editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit',1 ); ?>
										<?/* <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                                
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" /> 
				                            	
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CURRENT_IMAGE'].'('.$_params['image_width'].'x'.$_params['image_height'].')', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    */?>
					                    
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_ICON']?></label>      
					                    </div>
					                    <?/*<hr>*/?>
					                    <? //editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>	
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
					                        <?editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', $Elem,  $lang_index, 'edit'); ?>
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