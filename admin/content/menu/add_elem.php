<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");

if( $User->InGroup($_params['access']) ){
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
        
        $getparent = mysqli_query($db, "SELECT * FROM ".$_params['table']." WHERE id = ".$parent);
        $ParentElement = mysqli_fetch_assoc($getparent);
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                <h3><?=$_params['title']?> <?if($parent>0){?><small><?=$ParentElement['title_'.$Admin->lang]?></small><?}?></h3>
                <div>
                    <? 
                    //обработка запроса
                    if( isset( $_POST['ok'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
						
                        $arLinks = array();
                        
                        if( $ar_clean['page_id']>0 ){
                            $arl = $CCpu->getURLs($ar_clean['page_id']);
                            foreach( $Admin->ar_lang as $lang_index ){
                                $arLinks['link_'.$lang_index] = $arl[$lang_index];
                            }
                        }
                        addElement($_params['table'], $arLinks ); echo mysqli_error($db);

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
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <i style="font-size: 11px;color: steelblue"> <i class="fa fa-info-circle"></i> Вы можете выбрать страницу из списка, или самостоятельно прописать ссылка для каждого языка. В этом случае поля "Page address (url)"  не заполняются</i>
                                            </div>
                                            <label for="exampleInputEmail1" class="col-sm-3">Страница для ссылки <b class="red">*</b></label>
                                            <div class="col-sm-7">
                                                <select name="page_id" class="form-control input-sm">
                                                    <option value="0">Ручная установка ссылки</option>
                                                    <?
                                                    getPagesList($Admin->lang,1,0);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <input type="hidden" name="section_id" value="<?=$parent?>" />
                                        
                                        <?
                                        
                                        foreach( $Admin->langs as $lang_index =>$Language ){
                                            ?>
                                            <hr>
                                            <h3><?=$Language['title']?></h3>
                                            
                                            <? editElem('title',  $GLOBALS['CPLANG']['TITLE'], '1', '',  $lang_index, 'add', 1, 7 ); ?>
                                            
                                            <? editElem('link',  $GLOBALS['CPLANG']['PAGE_ADDR'], '1', '',  $lang_index, 'add', 0, 7 ); ?>
                                            <?
                                        }
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