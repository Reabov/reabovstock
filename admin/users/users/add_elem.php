<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if (isset($_GET['id'])) {$id = (int)$_GET['id'];}

if( $User->InGroup($_params['access']) )
{
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
    ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="btn-group backbutton">
                <a class="btn btn-block btn-info btn-xs" href="list_elem.php"> <?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
            </div>

            <div>
                <?
                //обработка запроса
                if( isset( $_POST['ok'] ) ){
                    $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
                    $exceptions[] = 'newpass';
                    $ar_clean['login'] = trim($ar_clean['login']);

                    // проверим, ежели такого логина нет
                    $getLogin = mysqli_query(" SELECT id FROM ws_users WHERE login = '".$ar_clean['login']."' ");
                    if( mysqli_num_rows($getLogin)>0 ){
                        ?>
                        <div class="alert alert-danger">
                            <?=$GLOBALS['CPLANG']['LOGIN_WORD']?>  <?=$ar_clean['login']?> <?=$GLOBALS['CPLANG']['EXISTS_WORD']?>
                        </div>
                        <?
                    }else{
                        // Изображение
                        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){
                            $FileName = file_name(8, $_FILES['image']['name']);
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"].$_params['image'];
                            // изуим загруженную картинку
                            $imginfo = getimagesize($_FILES['image']['tmp_name']);
                            if(!$imginfo){
                                exit('<div class="alert alert-danger">Image format error</div>');
                            }
                            make_thumb($_FILES['image']['tmp_name'], $uploadfile.$FileName, $_params['image_width'], $_params['image_height']);
                            unlink($uploadfile.$ar_clean['oldimg']);

                        }else{
                            exit('<div class="alert alert-danger">No image!</div>');
                        }

                        $pass = hash(sha512, trim($ar_clean['newpass']));
                        $pass = hash(sha512, $pass.$GLOBALS['security_salt']);

                        addElement( $_params['table'], array(), $txt, array('image'=>$FileName, 'pass'=>$pass ),  $exceptions );
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
                                <div class="tab-content form-horizontal">
                                    <div class="tab-pane active" id="tab_1">

                                        <? editElem('login', $GLOBALS['CPLANG']['USERLOGIN'], '1', '',  '', 'add', 1, 6 ); ?>
                                        <? editElem('user_name', $GLOBALS['CPLANG']['USER_NAME'], '1', '',  '', 'add', 1, 6 ); ?>
                                        <? // editElem('usergroup', $GLOBALS['CPLANG']['USER_LEVEL'], '2', '',  '', 'add', 1, 6, 'ws_user_group','name' ); ?>


                                        <div class="form-group">
                                            <label class="col-sm-3"> <?=$GLOBALS['CPLANG']['USER_LEVEL']?> <b class="red">*</b> </label>
                                            <div class="col-sm-6">
                                                <select required name="usergroup" class="form-control input-sm">
                                                    <?
                                                    $get = mysqli_query($db, " SELECT * FROM ws_user_group WHERE id != 1 ");
                                                    while($langSite = mysqli_fetch_assoc($get)){
                                                        ?>
                                                        <option value="<?=$langSite['id']?>"><?=$langSite['name']?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3">  <?=$GLOBALS['CPLANG']['LANG_CONTENT']?> <b class="red">*</b></label>
                                            <div class="col-sm-6">
                                                <select required type="text" name="lang" class="form-control input-sm">
                                                    <?
                                                    $get = mysqli_query($db, " SELECT * FROM ws_site_languages ");
                                                    while($langSite = mysqli_fetch_assoc($get)){
                                                        ?>
                                                        <option value="<?=$langSite['code']?>"><?=$langSite['title']?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-3"> <?=$GLOBALS['CPLANG']['LANG_INTERFACE']?> <b class="red">*</b></label>
                                            <div class="col-sm-6">
                                                <select required type="text" name="interface_lang" class="form-control input-sm">
                                                    <?
                                                    $get = mysqli_query($db, " SELECT * FROM ws_inteface_lang ");
                                                    while($langSite = mysqli_fetch_assoc($get)){
                                                        ?>
                                                        <option value="<?=$langSite['code']?>"><?=$langSite['title']?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3">
                                                <?=$GLOBALS['CPLANG']['COLOR_THEME']?> <b class="red">*</b>
                                            </label>
                                            <div class="col-sm-6">
                                                <select required name="skin" class="form-control input-sm">
                                                    <?
                                                    foreach ($skins as $skin) {
                                                        ?>
                                                        <option <?if($Elem['skin']==$skin){echo "selected";}?> value="<?=$skin?>"><?=$skin?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <? editElem('image', $GLOBALS['CPLANG']['CURRENT_IMAGE'], '5', '',  '', 'add', 1, 6, '', ''); ?>

                                        <? editElem('email', $GLOBALS['CPLANG']['EMAIL'], '1', '',  '', 'add', 1, 4 ); ?>

                                        <? // editElem('newpass', $GLOBALS['CPLANG']['PASSWORD'], '1', '',  '', 'add', 1, 4 ); ?>
                                        <?/*
                                        <div class="form-group">
                                            <label class="col-sm-3"><?=$GLOBALS['CPLANG']['PASSWORD']?> <b class="red">*</b></label>
                                            <div class="col-sm-4">
                                                <input required="" readonly type="text" name="newpass" class="form-control input-sm">
                                            </div>
                                        </div>
                                        */?>

                                        <div class="form-group">
                                            <label class="col-sm-3"><?=$GLOBALS['CPLANG']['PASSWORD']?> <b class="red">*</b></label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <div class="input-group-addon" style="cursor: pointer" onclick="gen_password(10,'newpass')" title="Сгенерировать пароль">
                                                        <i class="fa fa-fw fa-refresh"></i>
                                                    </div>
                                                    <input type="text" readonly class="form-control" name="newpass" id="newpass">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3"> </label>
                                            <div class="col-sm-4">
                                                <div> <span class="stronger"></span> </div>
                                                <div> <?=$GLOBALS['CPLANG']['COMPLICITED_PASSWORD']?>: <span id="indicator"> <?=$GLOBALS['CPLANG']['NOT']?> </span> </div>
                                            </div>
                                        </div>
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

<script>
    function gen_password(len,inptID){
        var password = "";
        var symbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!№;%:?*()_+=";
        for (var i = 0; i < len; i++){
            password += symbols.charAt(Math.floor(Math.random() * symbols.length));
        }
        // return password;
        $('#'+inptID).val( password );
        checkPassword($('#'+inptID));
    }
</script>
