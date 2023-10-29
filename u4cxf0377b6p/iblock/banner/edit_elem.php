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
				
                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
						
						 foreach ($Admin->ar_lang as $key => $value) { 
				            $txt[]='text_'.$value;
				            $exceptions[]='cpu_'.$value;
				        }
						
					$array=array();
					$active = checkboxParam('active');
					$array['active']=$active;
					
					foreach ($Admin->ar_lang as $key => $value) {
				        $exceptions[] = 'oldimg_'.$value;
						
						
				        
				        
				         // Изображение            
				        if( isset($_FILES['image_'.$value]['tmp_name']) && $_FILES['image_'.$value]['tmp_name']!='' ){ 
				            $ImageName = file_name(10, $_FILES['image_'.$value]['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$ImageName;
                            $imginfo = getimagesize($_FILES['image_'.$value]['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
                            //move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
							//make_thumb($_FILES['image_'.$value]['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							move_uploaded_file($_FILES['image_'.$value]['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg_'.$value]);
				            
				        }else{
				            $ImageName = $ar_clean['oldimg_'.$value];
				        }
						$array['image_'.$value]=$ImageName;
					}
											
					        
					     updateElement($id, $_params['table'], $array, $txt, array(), $exceptions);
						
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
									
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
										<?
									$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    <?if($Elem['image_'.$lang_index] != ''){?>
					                    <div class="form-group image_<?=$lang_index?>">
						                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
					                            <div class="col-sm-10">
					                            	<div class="col-sm-5">
					                                <div style="background: #fddf33;display: inline-block;padding: 5px">
					                                    <img style="max-width: 400px;" src="<?=$_params['image'].$Elem['image_'.$lang_index]?>" /> 
					                                  </div> 
					                                </div>
					                            	
					                            	<input type="hidden" name="oldimg_<?=$lang_index?>" value="<?=$Elem['image_'.$lang_index]?>" />  
					                            </div>         
						                    </div>
						                    <?}?>
                                        	<? editElem('image', $GLOBALS['CPLANG']['IMAGE']." ($lang_index) (".$_params['image_width'].'X'.$_params['image_height'].'px)', '5', $Elem,  $lang_index, 'edit', 0, 6, '', ''); ?>
                                       		<? //editElem('link', $GLOBALS['CPLANG']['LINK']." ($lang_index) ", '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
                                        <?}?>
                                        	
        
					                   
					                   
					                    
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

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>
 
 

 <script>
    function delimage(file, lang)
		{
		    var id = <?=$id?>;
		    
		    $.ajax({
		       type: "POST",
		       url: "/<?= WS_PANEL?>/ajax/",
		       data: "task=delimage&image="+file+"&id="+id+"&lang="+lang,
		       success: function(msg){
		         $(".image_"+lang).remove();
		       }
		     });
		    
		}
    </script>