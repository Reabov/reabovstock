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
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
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
                        // $exceptions[] = 'mailer';
                        // $exceptions[] = 'oldimg';




                        /*
                        ini_set('error_reporting', E_ALL);
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1); */


                        // -----
                        include_once( $_SERVER['DOCUMENT_ROOT'] . '/'. WS_PANEL .'/include/CImage.php' );
                        $CImage = new CImage();
                        // -----

                        if( isset( $_FILES['image']['tmp_name'] ) && $_FILES['image']['tmp_name'] != '' ) {
                            $FileName = file_name( 10 , $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"] . $_params['image'] . $FileName;
                            $tempPathImage = $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $FileName;

                            $imginfo = getimagesize( $_FILES['image']['tmp_name'] );
                            if(!$imginfo){
                                echo('Image format error');
                            } else {
                                // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                                $rmuf = move_uploaded_file( $_FILES['image']['tmp_name'], $tempPathImage );
                                if( $rmuf ) {

                                    $params_image = array();
                                    // $params_image['canvas'] = true; // белый холст // http://kartinki.moy.su/1/7/foto_smeshnye_belki.jpg

                                    /*
                                    $params_image['watermark'] = array(
                                        'path' => '/desk2021path/templates/lte/dist/img/file_delete.png' ,  // полный путь с названием картинки
                                        'position' => 'top_left' , // ( опции - top_left , bottom_left , top_right , bottom_right , center ) , по умолчанию - center
                                        'coef_size' => 0.55 ,  // размер водяного знака относительно нашего изображения ( > 0 && < 1 )
                                    );
                                    */

                                    // $params_image['cropped_mode'] = 'center'; // center если хотим обрезать изображение по центру (если mode = cropped)
                                    // $params_image['save_original_image'] = true; // если вы задали ресайз по высоте или ширине но изображение меньше тогда просто сохраним (ожидает true)
                                    $params_image['width'] = $_params['image_width'];
                                    $params_image['height'] = $_params['image_height'];
                                    $params_image['mode'] = 'resize'; // resize , cropped
                                    $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                                    if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }

                                } else {
                                    echo '<br> Ошибка: файл не был загружен <br>';
                                }
                            }

                        }

                        /*
                        else {
                            $FileName = $ar_clean['oldimg'];
                        }
                        */

                        // Изображение
                        /* старый способ
                        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){
                            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;

                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
                            
                        }
                        */
						
                        addElement($_params['table'], array(), $txt, array('image' => $FileName), $exceptions);
                        
                        $id = mysqli_insert_id($db);
                        
                        /*
                        if( isset($_POST['mailer']) ){
                            mysqli_query($db, " INSERT INTO ws_mailer_news (`news_id`,`status`,`date`) VALUES ('$id',0,NOW()) ");
                        }
                        */
                        
                        if($id>0 && $_params['page_id'] > 0) {
                            foreach ($Admin->ar_lang as $lang_index) {
                                // ЧПУ
                                $arrURL[$lang_index] = $_POST['cpu_' . $lang_index];
                                if ($arrURL[$lang_index] == '') {
                                    $arrURL[$lang_index] = $_POST['title_' . $lang_index];
                                }
                            }
                            $arrURL = $CCpu->controlURL($arrURL);
                            $arrURL = $CCpu->regionURL($arrURL);
                            $addCpu = $CCpu->updateElementCpu($arrURL, $_params['page_id'], $id);

                            // если добавляли фото в галлерею
                            if(isset($_SESSION['photo_gallery_add_page']) && !empty($_SESSION['photo_gallery_add_page'])) {
                                mysqli_query($db, " UPDATE `ws_photogallery` SET `elem_id` = '". $id ."' WHERE page_id = '". $_params['page_id'] ."' AND id IN (". implode(',', $_SESSION['photo_gallery_add_page']) .")  ");
                            }
                        }
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
                                    <?
                                    $cur_tab = 2;
                                    foreach( $Admin->langs as $lang_index =>$Language ){
                                        ?>
                                        <li class=""><a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false"><?=$Language['title']?></a></li>
                                        <?
                                        $cur_tab++;
                                    }
                                    ?>


                                    <li class="">
                                        <a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false">
                                            <?=$GLOBALS['CPLANG']['PAGE_PHOTOGALLERY']?>
                                        </a>
                                    </li> <? $cur_tab++; ?>
                                </ul>
                                
                                <div class="tab-content form-horizontal">
                                    
                                    <div class="tab-pane active" id="tab_1">
                                        <? //editElem('mailer', 'Рассылка', '3', '', '', 'add' ); ?>
                                        <? editElem('image', $GLOBALS['CPLANG']['IMAGE'].' ('.$_params['image_width'].'X'.$_params['image_height'].'px)', '5', '',  '', 'add', 1, 6, '', ''); ?>
                                        <? editElem('date',  $GLOBALS['CPLANG']['DATE'], '6', '',  '', 'add', 1, 2 ); ?> 
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
                                            <? editElem('preview', $GLOBALS['CPLANG']['PREVIEW'], '8', '',  $lang_index, 'add', 1); ?>
                                            <? editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', '',  $lang_index, 'add'); ?>
                                        </div>
                                        <?
                                    }  
                                    ?>

                                    <div class="tab-pane" id="tab_<?=$c_tab?>">
                                        <?
                                        /*галерея*/
                                        include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/lib/include/gallery.php");

                                        $c_tab++;
                                        ?>
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

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>