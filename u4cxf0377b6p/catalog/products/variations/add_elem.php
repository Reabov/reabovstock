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
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php?elem_id=<?=$_GET['elem_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    //обработка запроса
                    if( isset( $_POST['ok'] ) )
                    {
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
						$array = array();
                        $exceptions = array();
                      /*
					    // Изображение
                        include_once(  $_SERVER['DOCUMENT_ROOT'] .'/ws/lib/image-toolkit/AcImage.php' );

                        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' )
                        {
                            $FileName = file_name(10, $_FILES['image']['name'] );

                            $temp_path = $_SERVER['DOCUMENT_ROOT'] . '/upload/'.$FileName;
                            $res_copy = copy( $_FILES['image']['tmp_name'] , $temp_path );
                            $img = AcImage::createImage( $temp_path );
                            $img->resizeByWidth( (int)$_params['image_width'] );

                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            $img->save( $uploadfile );
                            unlink( $temp_path );
                        }*/

                     
						$array['section_id']=$_GET['elem_id'];
                        addElement($_params['table'], $array, $txt, $fields , $exceptions);
                    }
                    ?>
                </div>
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
                                    	<?
                                        $c_tab = 2;
                                        foreach( $Admin->ar_lang as $lang_index ){  
                                            editElem('title', $GLOBALS['CPLANG']['TITLE']." (".$lang_index.")", '1', $Elem,  $lang_index, 'add', 1, 7 );
                                        }?>
                                        <? //editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', '',  '', 'add', 1, 2,'','',500 ); ?>
                                    </div>

                                    <?/*
                                    $c_tab = 2;
                                    foreach( $Admin->ar_lang as $lang_index ){
                                        ?>
                                        <div class="tab-pane" id="tab_<?=$c_tab++?>">


                                            <? editElem('image_mobile', $GLOBALS['CPLANG']['IMAGE'].' mobile ('.$_params['image_width_mobile'].'X'.$_params['image_height_mobile'].'px)','5','',$lang_index, 'add', 1, 6,'','');?>

                                            <? editElem('title',  $GLOBALS['CPLANG']['TITLE'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('sub_title',  $GLOBALS['CPLANG']['TITLE'] .' (2)', '1', '',  $lang_index, 'add', 0, 7 ); ?>

                                            <? editElem('link', 'Link' , '1', '',  $lang_index, 'add', 0, 7 ); ?>

                                            <?// editElem('page_title', $GLOBALS['CPLANG']['PAGE_TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <? //editElem('cpu', $GLOBALS['CPLANG']['PAGE_ADDR'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? //editElem('meta_d', $GLOBALS['CPLANG']['PAGE_METAD'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? //editElem('meta_k', $GLOBALS['CPLANG']['PAGE_METAK'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? //editElem('preview', $GLOBALS['CPLANG']['PREVIEW'], '8', '',  $lang_index, 'add', 1); ?>
                                            <? //editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', '',  $lang_index, 'add'); ?>
                                        </div>
                                        <?
                                    }  */
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

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>