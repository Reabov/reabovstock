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
                    	$green = checkboxParam('green');
						
                        addElement($_params['table'],array('green' => $green));
						
						$id = mysqli_insert_id($db);
						if($green == '1'){
							$Db->q("UPDATE `".$_params['table']."` SET green = 0 WHERE id != ".$id);
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
                                </ul>
                                <div class="tab-content form-horizontal">
                                    <div class="tab-pane active" id="tab_1">
                                    	<? editElem('green', 'Green', '3', '', '', 'add' ); ?>
                                        <?
                                        foreach( $Admin->ar_lang as $lang_index ){ 
                                            editElem('text',  $GLOBALS['CPLANG']['TITLE']." (".$lang_index.")", '1', '',  $lang_index, 'add', 1, 7 );
                                        }  
                                        ?>
                                      <? editElem('year','Год', '1', '',  '', 'add', 1, 2,'',''); ?>
                                        <? editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', '',  '', 'add', 1, 2,'','',500 ); ?>
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