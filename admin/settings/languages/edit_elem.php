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
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php"> <?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> 
                    	<?=$GLOBALS['CPLANG']['ADD_ELEM']?> 
                    </a>
                </div>
                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        $active = checkboxParam('active');
						
				       /* foreach ($Admin->ar_lang as $key => $value) { 
				            $txt[]='text_'.$value;
				            $txt[]='preview_'.$value;
				            $exceptions[]='cpu_'.$value;
				        }*/
				        //$exceptions[] = 'oldimg';
				        
				        
				        // Изображение            
				       /* if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
                            make_thumb($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
				            unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$ar_clean['oldimg']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }*/

				        updateElement($id, $_params['table'], array('active'=>$active), $txt, array(), $exceptions);

				    }

                    $db_element = mysqli_query( $db , "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array( $db_element );

                    
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
									<li class="active">
										<a href="#tab_1" data-toggle="tab" aria-expanded="true">
											<?=$GLOBALS['CPLANG']['ALLADATA']?>
										</a>
									</li>
									<?
									/*$cur_tab = 2;
									foreach( $Admin->langs as $lang_index =>$Language ){
				                        ?>
				                        <li class=""><a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false"><?=$Language['title']?></a></li>
				                        <?
				                        $cur_tab++;
				                    }*/
									?>
									<!-- <li class=""><a href="#tab_10" data-toggle="tab" aria-expanded="false">Фотогалерея</a></li> -->
								</ul>
								
								<div class="tab-content form-horizontal">
									<div class="tab-pane active" id="tab_1">
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'] , '3', $Elem, '', 'edit' ); ?>
					                    
					                    <? /*<div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_CURENTIMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div> */?>
					                    <? //editElem('image', $GLOBALS['ar_define_langterms']['MSG_ADM_CHANGE_IMAGE'], '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>

					                    
					                    
					                    <? editElem('title',$GLOBALS['CPLANG']['TITLE'] , '1', $Elem,  '', 'edit', 1, 3 ); ?>
					                    <? editElem('sort', $GLOBALS['CPLANG']['SORT'] , '1', $Elem,  '', 'edit', 1, 2 ); ?>

					                    
									</div>
									<?
									/*$c_tab = 2;
					                foreach( $Admin->ar_lang as $lang_index ){ 
					                    ?>
					                    <div class="tab-pane" id="tab_<?=$c_tab++?>">
					                        <? editElem('title', $GLOBALS['ar_define_langterms']['MSG_ADM_TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                        
					                        <hr>
											
                                            <? editElem('image_alt', "Image alt", '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
                                            <? editElem('image_title', "Image title", '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
					                    </div>
					                    <?
					                }  */
									?>
									<!--<div class="tab-pane" id="tab_10">
                                        <?
                                        /*галерея*/
                                        include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/lib/include/gallery.php");
                                        ?>
                                        
                                </div> -->
									
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