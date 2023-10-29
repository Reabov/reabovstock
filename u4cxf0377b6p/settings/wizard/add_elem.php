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
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    //обработка запроса
                    if( isset( $_POST['ok'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        $active = checkboxParam('active');
                        foreach ($Admin->ar_lang as $key => $value) { 
                            $txt[]='text_'.$value;
                            $txt[]='preview_'.$value;
                            $exceptions[]='cpu_'.$value;
                        }
                        
                        // Изображение            
                        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){
                            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'].$FileName;
                            // изуим загруженную картинку
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('Image format error');
                            }
                            make_thumb($_FILES['image']['tmp_name'], $uploadfile, $_params['image_width'], $_params['image_height']);
                            
                        }
                        addElement($_params['table'], array(), $txt, array('image'=>$FileName, 'date'=>'NOW()'), $exceptions); 
                        $id = mysqli_insert_id($db);
                         foreach( $Admin->ar_lang as $lang_index ){
                                // ЧПУ
                                $arrURL[$lang_index] = $_POST['cpu_'.$lang_index];
                                if($arrURL[$lang_index]==''){
                                    $arrURL[$lang_index] = $_POST['title_'.$lang_index];
                                }
                         }
                         $arrURL = $CCpu->controlURL($arrURL); 
                         $addCpu = $CCpu->updateElementCpu($arrURL, $_params['page_id'],  $id);
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
                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_ALLDATA']?></a></li>
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
                                        <? editElem('image', $GLOBALS['ar_define_langterms']['MSG_ADM_IMAGE'], '5', $Elem,  '', 'add', 1, 6, '', ''); ?>
                                        <? editElem('sort', $GLOBALS['ar_define_langterms']['MSG_ADM_SORT'], '1', $Elem,  '', 'add', 1, 2,'','',500 ); ?>
                                    </div>
                                    <?
                                    $c_tab = 2;
                                    foreach( $Admin->ar_lang as $lang_index ){ 
                                        ?>
                                        <div class="tab-pane" id="tab_<?=$c_tab++?>">
                                            <? editElem('title', $GLOBALS['ar_define_langterms']['MSG_ADM_TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            <? editElem('page_title', $GLOBALS['ar_define_langterms']['MSG_ADM_PAGETAGTITLE'], '1', $Elem,  $lang_index, 'add', 1, 7 ); ?>
                                            <? editElem('cpu', 'Адрес страницы', '1', $Elem,  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('meta_d', $GLOBALS['ar_define_langterms']['MSG_ADM_METAD'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('meta_k', $GLOBALS['ar_define_langterms']['MSG_ADM_METAK'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <? editElem('preview', $GLOBALS['ar_define_langterms']['MSG_ADM_NEWS_PREVIEW_256'], '4', $Elem,  $lang_index, 'add'); ?>
                                            <? editElem('text', $GLOBALS['ar_define_langterms']['MSG_ADM_TEXT'], '4', '',  $lang_index, 'add'); ?>
                                        </div>
                                        <?
                                    }  
                                    ?>

                                </div>
                            </div>
                            <div style="text-align: center">
                                <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['ar_define_langterms']['MSG_ADM_SAVE']?>" name="ok" />
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