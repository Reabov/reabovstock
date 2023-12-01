<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");

if( $User->InGroup($_params['access']) ){
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

	$db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$parent."'");
    $ParentElem = mysqli_fetch_assoc($db_element); 

        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php?parent=<?=$parent?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    //обработка запроса 
                    if( isset( $_POST['ok'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
                        foreach ($Admin->ar_lang as $key => $value) { 
                            $txt[]='text_'.$value;
                            $exceptions[]='cpu_'.$value;
                        }
                        
						$exceptions[]='products';	
                        $active = checkboxParam('active');			
						$main = checkboxParam('main');
						$next_main = checkboxParam('next_main');							
						
						
						$array=array(); 
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
                            
                        }
						
						if( isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name']!='' ){
                            $VideoName = file_name(10, $_FILES['video']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['video'].$VideoName;
							
							move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile);
                        }
						
						
						 // Изображение        
                       
						$array=array('image' => $FileName,'video' => $VideoName);
						
                        addElement($_params['table'], $array, $txt, array('active'=>$active,'main'=>$main,'next_main'=>$next_main), $exceptions); 
                        $id = mysqli_insert_id($db);
						
                        /* if($ar_clean['products']){
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
                    ?>
                </div>
            </section>
			<style>
				.sel {
					font-weight: 600;
				}
			</style>
            <section class="content">
                <div class="row">
                	
                	<div class="col-xs-12">
                		<h3><?=$ParentElem['title_'.$Admin->lang]?></h3>
                	</div>
                	
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
                                    	<?editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', '', '', 'add',1 ); ?>
                                    	
                                    	<?editElem('main', 'Слайдер на главной', '3', '', '', 'add' ); ?>
                                    	<?editElem('next_main', 'Нижний слайдер на главной', '3', '', '', 'add' ); ?>
                                    	
                                        <? editElem('image', $GLOBALS['CPLANG']['IMAGE'].' ('.$_params['image_width'].'X'.$_params['image_height'].'px)', '5', '',  '', 'add', 1, 6, '', ''); ?>
                                        <? editElem('video', 'Video', '5', '',  '', 'add', 1, 6, '', ''); ?>
                                        
                                        <? editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', '',  '', 'add', 1, 2,'','',500 ); ?>
                                        
                                        <?/* <div class="form-group">
        									<label class="col-sm-3">Select products</label>
	                                    	<div class="col-sm-9">
												<select type="text" name="products[]" class="form-control input-sm" style="min-height: 150px" multiple>													
													<? $products = mysqli_query($db, " SELECT * FROM `ws_categories_elements` WHERE active = 1 ORDER BY sort DESC ");
													while($product = mysqli_fetch_assoc($products)){
														?>
														<option class="prod" value="<?=$product['id']?>"><?=$product['title_'.$CCpu->lang]?></option>
														<?
													}?>												
											    </select>
											</div>											
										</div> */?>
                                    </div>
                                    <?
                                    $c_tab = 2;
                                    foreach( $Admin->ar_lang as $lang_index ){ 
                                        ?>
                                        <div class="tab-pane" id="tab_<?=$c_tab++?>">
                                            <? editElem('title',  $GLOBALS['CPLANG']['TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <?// editElem('sub_title',  'Sub title', '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <? editElem('cpu', $GLOBALS['CPLANG']['PAGE_ADDR'], '1', '',  $lang_index, 'add', 0, 7 ); ?> 
                                            <? editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <?editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', '',  $lang_index, 'add'); ?>
                                        </div>
                                        <?
                                    }  
                                    ?>
  
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