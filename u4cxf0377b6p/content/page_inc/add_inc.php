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
                    $ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

                    foreach ($Admin->ar_lang as $key => $value) {
                        $txt[]='text_'.$value;
                    }

                    $code = str_replace(" ", "_", $ar_clean['code']);
                    $code = $CCpu->translitURL($code);
                    $code = strtoupper($code);

                    $is_el = mysqli_query($db, "SELECT id FROM `".$_params['table']."` WHERE `code`='".$code."'");
                    $el_count = mysqli_num_rows($is_el);

                    if( $el_count > 0 ){
                        ?>
                        <div class="alert alert-danger"> <?=$GLOBALS['CPLANG']['CODE']?> <?=$code?> <?=$GLOBALS['CPLANG']['EXISTS_WORD']?> </div>

                        <?
                        if( $User->InGroup( 1 ) ){
                            $Elem['code'] = $code;
                            ?>
                            <div class="codeBlock">
                                <div id="<?=uniqid()?>" class="php_code" style="font-family: Consolas, Courier">
                                    <?echo"$";echo"Main->GetPageIncData('".$Elem['code']."' , ";echo "$";echo "CCpu->lang)";echo"<br>";?>
                                </div>
                                <div id="<?=uniqid()?>" class="html_code" style="font-family: Consolas, Courier">
                                    <?echo"&lt;?=$";echo"Main->GetPageIncData('".$Elem['code']."' , ";echo "$";echo "CCpu->lang)?&gt;<br>";?>
                                </div>
                                <br>
                                <div style="position: absolute;bottom: 3px;" class="notific"> </div>
                            </div>
                            <?
                        }
                        ?>
                        
                        <?
                    }else{
                        addElement($_params['table'], array('code'=>$code),$txt);
                    }

                    // addElement($_params['table'], array(), $txt, array());
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
                                        editElem('code', 'Code (пример - TEXT_NEWSLETTER )', '1', '',  '', 'add', 1, 7 );

                                        $c_tab = 2;
                                        foreach( $Admin->ar_lang as $lang_index ){
                                            editElem('title',  $GLOBALS['CPLANG']['TITLE']." (".$lang_index.")", '1', '',  $lang_index, 'add', 1, 7 );
                                            editElem('text', $GLOBALS['CPLANG']['TEXT']." (".$lang_index.")", '4', '', $lang_index, 'add');

                                            ?>
                                            <hr>
                                            <?
                                        }
                                        ?>
                                        <? // editElem('sort',  $GLOBALS['CPLANG']['SORT'], '1', '',  '', 'add', 1, 2,'','',500 ); ?>
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