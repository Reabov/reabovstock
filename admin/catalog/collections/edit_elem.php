<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
	
	$db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$_GET['collections_id']."'");
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
						$main = checkboxParam('main');
						$next_main = checkboxParam('next_main');
						
				        foreach ($Admin->ar_lang as $key => $value) { 
				            $txt[]='text_'.$value;
				            $exceptions[]='cpu_'.$value;
				        }
							
						$exceptions[] = 'products';
						$exceptions[] = 'oldimg';
						$exceptions[] = 'oldvideo';
						
						
				        // Изображение      
				        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
							//createThumbnail($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height'], array(255,255,255));
							//make_thumb($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }
						
						
						// Изображение      
				        if( isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name']!='' ){ 
				            $VideoName = file_name(10, $_FILES['video']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['video'].$VideoName;
                            
							move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['video'].$ar_clean['oldvideo']);
				        }else{
				            $VideoName = $ar_clean['oldvideo'];
				        }
						
						
						
						// Изображение
				        updateElement($id, $_params['table'], array('active'=>$active,'main'=>$main,'next_main'=>$next_main), $txt, array('image'=>$FileName,'video'=>$VideoName), $exceptions);
                        
						/* if($ar_clean['products']){
							mysqli_query($db, "DELETE FROM `ws_collections_products` WHERE elem_id = '".$id."' ");
							foreach ($ar_clean['products'] as $product_id) {
								mysqli_query ($db, "INSERT INTO `ws_collections_products` (elem_id, product_id) VALUES ('".$id."', '".$product_id."') ");
							}
						} */
						
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
			<style>
				.sel {
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
								</ul>
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<?editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit',1 ); ?>
										
										<?editElem('main', 'Слайдер на главной', '3', $Elem, '', 'edit' ); ?>
										<?editElem('next_main', 'Нижний слайдер на главной', '3', $Elem, '', 'edit' ); ?>
										
										<div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />
				                            </div>         
					                    </div>
					                    <? editElem('image', $GLOBALS['CPLANG']['CURRENT_IMAGE'].'('.$_params['image_width'].'x'.$_params['image_height'].')', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3">Current video</label>
				                            <div class="col-sm-10">
				                            	<video style="max-width: 300px;" src="<?=$_params['video'].$Elem['video']?>" />
				                            	</video>
				                            	<input type="hidden" name="oldvideo" value="<?=$Elem['video']?>" />
				                            </div>         
					                    </div>
					                    <? editElem('video', 'Video', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    
					                    <? editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2,'','',500 ); ?>
					                    
					                    <?/* $marks = $Db->getfield("SELECT product_id FROM ws_collections_products WHERE elem_id = ".$Elem['id'], 'product_id')?>
					                    <div class="form-group">
        									<label class="col-sm-3">Products</label>
	                                    	<div class="col-sm-9">
												<select type="text" name="products[]" class="form-control input-sm" style="min-height: 150px" multiple>										
													<? $products = mysqli_query($db, " SELECT * FROM `ws_categories_elements` WHERE active = 1 ORDER BY sort DESC ");
													while($product = mysqli_fetch_assoc($products)){
														?>
														<option class="prod <?if(in_array($product['id'], $marks)){echo "sel";}?> " <?if(in_array($product['id'], $marks)){echo "selected";}?> value="<?=$product['id']?>"><?=$product['id'].'->'.$product['title_'.$CCpu->lang]?></option>
														<?
													}?>												
											    </select>
											</div>											
										</div> */?>
					                    	
									</div>
									
									<?
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">
					                    	<?// editElem('h1', 'h1', '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        <? editElem('title', $GLOBALS['CPLANG']['TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        <?// editElem('sub_title', 'Sub title', '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
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
<script>
	$('.prod').on('click',function(){
		$(this).toggleClass('sel');
		
		$('.prod').each(function(){
			var check = $(this).hasClass('sel');
			$(this).prop('selected',check);
		})
		
	})
</script>