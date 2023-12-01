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
                        	$active = checkboxParam('active');	
							$type= checkboxParam('type');									
						
						// -----
                        include_once( $_SERVER['DOCUMENT_ROOT'] . '/'. WS_PANEL .'/include/CImage.php' );
                        $CImage = new CImage();
                        // -----
						
						$array=array(); 
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
							//createThumbnail($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height'], array(255,255,255));
                            //make_thumb($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
							
							//move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
                            
                        }
						
						 // Изображение        
                       
						$array=array('image' => $FileName);
						
                        addElement($_params['table'], $array, $txt, array(), $exceptions); 
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
                         
                    }
                    ?>
                </div>
            </section>

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
                                        <? //editElem('image', $GLOBALS['CPLANG']['IMAGE'].' ('.$_params['image_width'].'X'.$_params['image_height'].'px)', '5', '',  '', 'add', 0, 6, '', ''); ?>
                                        <? //editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', '',  '', 'add', 1, 2,'','',500 ); ?>
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