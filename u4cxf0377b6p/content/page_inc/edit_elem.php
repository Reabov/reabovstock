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
            <div>
                <?
                //обработка запроса
                if( isset( $_POST['ok'] ) ){
                    $ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                    foreach ($Admin->ar_lang as $lang_index) {
                        $txt[]='text_'.$lang_index;
                    }
                    updateElement($id, $_params['table'], array(), $txt);
                }

                // получаем значение элемента
                $getElement = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id = ".$id);
                $Elem = mysqli_fetch_assoc($getElement);
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
                                    <?
                                    $cur_tab = 1; $Classactive = 'active';
                                    foreach( $Admin->langs as $lang_index =>$Language ){
                                        ?>
                                        <li class="<?=$Classactive?>"><a href="#tab_<?=$cur_tab?>" data-toggle="tab" aria-expanded="false"><?=$Language['title']?></a></li>
                                        <?
                                        $cur_tab++;
                                        $Classactive = '';
                                    }
                                    ?>
                                </ul>
                                <div class="tab-content form-horizontal">
                                    <?
                                    $c_tab = 1;$Classactive = 'active';
                                    foreach( $Admin->ar_lang as $lang_index ){
                                        ?>
                                        <div class="tab-pane <?=$Classactive?>" id="tab_<?=$c_tab++?>">
                                            <? editElem('title', $GLOBALS['CPLANG']['TITLE'], '1', $Elem,  $lang_index, 'edit'); ?>
                                            <? editElem('text', $GLOBALS['CPLANG']['TEXT'], '4', $Elem,  $lang_index, 'edit'); ?>
                                        </div>
                                        <? $Classactive = '';
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
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>
