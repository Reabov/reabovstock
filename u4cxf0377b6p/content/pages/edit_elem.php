<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");

if( $User->InGroup( $_params['access'] ) ){
	
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
                    	
                        $ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);  
						
                        foreach ($Admin->ar_lang as $lang_index) {
                            $txt[]='text_'.$lang_index;
                            $exceptions[]='cpu_'.$lang_index;
                            $arrURL[$lang_index] = $_POST['cpu_'.$lang_index];
                            if($arrURL[$lang_index]==''){
                                $arrURL[$lang_index] = $ar_clean['title_'.$lang_index];
                            }
                        }  
						 
                            
                        updateElement($id, $_params['table'], array(), $txt, array(), $exceptions);
                        
						
						if( $id!=2 ){
	                        //проверка правильности написания
	                        $arrURL = $CCpu->controlURL($arrURL);
                            $arrURL = $CCpu->regionURL($arrURL); 
							// не позволяем убить главную страницу
							if( $id == 1 ){
								$arrURL = $CCpu->controlMainPageURL($arrURL);
							}
							
							$arrURL = $CCpu->regionURL($arrURL); 
	                        //обновление
	                        $CCpu->updateCpu($arrURL,$id);
						}
                    }
                    
                    // получаем значение элемента
                    $getElement = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id = ".$id);
                    $Elem = mysqli_fetch_assoc($getElement);
					
                    ?>
                </div>
                
                <h1><i> <?=$Elem['title_'.$Admin->lang]?> </i></h1>
            </section>

            <section class="content">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="">
                            <form method="post" enctype="multipart/form-data">
	                            <div class="nav-tabs-custom">
	                                <ul class="nav nav-tabs">
	                                    <?
	                                    $cur_tab = 1; $Classactive = 'active';
	                                    foreach( $Admin->langs as $lang_index =>$Language ){
	                                        ?>
		                                        <li class="<?=$Classactive?>">
		                                        	<a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false">
		                                        		<?=$Language['title']?>
		                                        	</a>
		                                        </li>
	                                        <?
	                                        $cur_tab++;
	                                        $Classactive = '';
	                                    }
	                                   
		                                if( $Elem['show_gallery']==1 ){
		                                    ?>
		                                    <li class="">
		                                    	<a href="#tab_10" data-toggle="tab" aria-expanded="false"> 
		                                    		<?=$GLOBALS['CPLANG']['PAGE_PHOTOGALLERY']?>  
		                                    	</a>
		                                    </li>
		                                    <?
		                                }
	                                ?>
	                                </ul>
	                                
	                                <div class="tab-content form-horizontal">
	                                    <?
	                                    $c_tab = 1;$Classactive = 'active';
	                                    foreach( $Admin->ar_lang as $lang_index ){ 
	                                        ?>
	                                        <div class="tab-pane <?=$Classactive?>" id="tab_<?=$c_tab++?>">
	                                            <? editElem('title', $GLOBALS['CPLANG']['TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
	                                            <? editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
	                                            <?if( $id!=2 ){?>
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1" class="col-sm-3">
	                                                    <?=$GLOBALS['CPLANG']['LINK']?> 
	                                                    (<span style="text-transform: uppercase"><?=$lang_index?></span>):
	                                                   
	                                                </label>
	                                                <div class="col-sm-7">
	                                                    <?
	                                                        $getLink = mysqli_query($db,"SELECT * 
	                                                        	FROM ws_cpu 
	                                                        	WHERE page_id = $id AND lang = '$lang_index'"); 
	                                                        $links = mysqli_fetch_assoc($getLink);
	                                                    ?>
	                                                    <input  type="text" name="cpu_<?=$lang_index?>" value="<?=$links["cpu"]?>" class="form-control input-sm">
	                                                </div>
	                                            </div>
	                                            <?}?>
	                                            <? editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
	                                            <? editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', $Elem,  $lang_index, 'edit', 0, 7 ); ?>
	                                            
	                                            <? 
	                                            if( $Elem['show_text']==1 ){
	                                            	editElem('text', $GLOBALS['CPLANG']['PAGE_TEXT'], '4', $Elem,  $lang_index, 'edit');
	                                            }
	                                            ?>
	                                            
	                                        </div>
	                                        <? $Classactive = '';
	                                    }  
	                                    if( $Elem['show_gallery']==1 ){
	                                        ?>
	                                        <div class="tab-pane" id="tab_10">
	                                            <?
	                                            /*галерея*/
	                                            include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/lib/include/gallery.php");
	                                            ?>
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

    <?}?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>
