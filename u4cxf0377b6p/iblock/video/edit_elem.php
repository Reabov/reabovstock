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
				        
						
						 
				            $txt[]='text_'.$value;
				            $exceptions[]='cpu_'.$value;
				        
						
					$array=array();
					$active = checkboxParam('active');
					$array['active']=$active;
						$exceptions[] = 'oldvideo';
						$exceptions[] = 'oldmob';
						 // Video            
				        if( isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['video']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                         
						
                            //move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
							//make_thumb($_FILES['image_'.$value]['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldvideo']);
				        }else{
				            $FileName = $ar_clean['oldvideo'];
				        }

						if( isset($_FILES['mob_video']['tmp_name']) && $_FILES['mob_video']['tmp_name']!='' ){ 
				            $MobName = file_name(10, $_FILES['mob_video']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$MobName;
                         
						
                            //move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
							//make_thumb($_FILES['image_'.$value]['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							move_uploaded_file($_FILES['mob_video']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldmob']);
				        }else{
				            $MobName = $ar_clean['oldmob'];
				        }


						$array['video']=$FileName;
						$array['mob_video']=$MobName;
						
					     updateElement($id, $_params['table'], $array, $txt, array(), $exceptions);
						
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);
                    
					?>
				</div>
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php?parent=<?=$Elem['section_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
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
										<? //editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
						                    <div class="form-group image">
						                        <label for="exampleInputEmail1" class="col-sm-3">Видео</label>
					                            <div class="col-sm-10">
					                            	<div class="col-sm-5">
					                                <div style="background: coral;display: inline-block;padding: 5px">
									                    <video width="700" height="240" controls>
									                    	<source src="<?=$_params['image'].$Elem['video']?>" />
									                    	Your browser does not support the video tag.
														</video>
					                                  </div> 
					                                </div>
					                            	
					                            	<input type="hidden" name="oldvideo" value="<?=$Elem['video']?>" />  
					                            </div>         
						                    </div>
                                        	<? editElem('video', $GLOBALS['CPLANG']['VIDEO'], '5', $Elem,  $lang_index, 'edit', 0, 6, '', ''); ?>
                                        	
                                        	
                                        	<div class="form-group image">
						                        <label for="exampleInputEmail1" class="col-sm-3">Видео (мобильная версия)</label>
					                            <div class="col-sm-10">
					                            	<div class="col-sm-5">
					                                <div style="background: coral;display: inline-block;padding: 5px">
									                    <video width="700" height="240" controls>
									                    	<source src="<?=$_params['image'].$Elem['mob_video']?>" />
									                    	Your browser does not support the video tag.
														</video>
					                                  </div> 
					                                </div>
					                            	
					                            	<input type="hidden" name="oldmob" value="<?=$Elem['mob_video']?>" />  
					                            </div>         
						                    </div>
                                        	<? editElem('mob_video', $GLOBALS['CPLANG']['VIDEO'], '5', $Elem,  $lang_index, 'edit', 0, 6, '', ''); ?>
                                        	
                                       		<? //editElem('link', $GLOBALS['CPLANG']['LINK']." ($lang_index) ", '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
                                       		
                                       		<div class="form-group">
        										<label class="col-sm-12"> Максимальная ширина экрана для мобильного видео</label>
        	                					<div class="col-sm-1">
                									<input type="number" value="<?=$Elem['mob_size']?>" name="mob_size" min="280" max="1400" class="form-control input-sm" >
                								</div>px
    										</div>
                                        

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
