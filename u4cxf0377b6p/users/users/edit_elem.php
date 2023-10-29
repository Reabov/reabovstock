<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} 

$canEdit = false;
if( $User->user_id == $id || $User->InGroup(array(1,2,3)) )

if( $User->InGroup($_params['access']) ){
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

    if ( !isset($id) ):
        ?>
        <?=$GLOBALS['ar_define_langterms']['MSG_ADM_NODATAFOREDIT']?>
        <?
    else:
        $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
        if ( $Elem = mysqli_fetch_array($db_element) )
        {
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
                        $active = checkboxParam('active');
                        $block = checkboxParam('block');

                        $exceptions[] = 'oldimg';
                        $exceptions[] = 'newpass';
                        $exceptions[] = 'newpassrepeat';

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
                            $FileName = $ar_clean['oldimg'];
                        }

                        updateElement($id, $_params['table'], array('active'=>$active,'block'=>$block,'image'=>$FileName), array(), array(), $exceptions);

                        $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                        $Elem = mysqli_fetch_array($db_element);

                        if( isset( $ar_clean['newpass'] ) && !empty( trim( $ar_clean['newpass'] ) ) )
                        {

                            $pass = hash(sha512, trim($ar_clean['newpass']));
                            $pass = hash(sha512, $pass.$GLOBALS['security_salt']);
                            //$password_shelf_life = date("Y-m-d", strtotime('+3 months'));

                            $update = mysqli_query($db, "UPDATE ws_users SET pass = '".$pass."' WHERE id = ".$id);
                            if($update){
                                ?>
                                <div class="alert alert-info">
                                    <?  echo "Passowrd was changed"; ?>
                                </div>
                                <?
                            }else{
                                // echo mysqli_error($db);
                            }
                        }
                    }
                    ?>
                </div>
                <h1><i><?=$Elem['user_name']?></i></h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="">
                            <form method="post" enctype="multipart/form-data">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content form-horizontal">
                                        <div class="tab-pane active" id="tab_1">


                                            <? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
                                            <? // editElem('block', $GLOBALS['CPLANG']['IS_BLOCKED'], '3', $Elem, '', 'edit' ); ?>
                                            <? editElem('login', $GLOBALS['CPLANG']['USERLOGIN'], '1', $Elem,  '', 'edit', 1, 6 ); ?>
                                            <? editElem('user_name', $GLOBALS['CPLANG']['USER_NAME'], '1', $Elem,  '', 'edit', 1, 6 ); ?>
                                            <? editElem('email', $GLOBALS['CPLANG']['EMAIL'], '1', $Elem,  '', 'edit', 1, 6 ); ?>
                                            <? // editElem('usergroup', $GLOBALS['CPLANG']['USER_LEVEL'], '2', $Elem,  '', 'edit', 1, 6, 'ws_user_group','name' ); ?>


                                            <div class="form-group">
                                                <label class="col-sm-3"> <?=$GLOBALS['CPLANG']['USER_LEVEL']?> <b class="red">*</b> </label>
                                                <div class="col-sm-6">
                                                    <select required name="usergroup" class="form-control input-sm">
                                                        <? if($Elem['usergroup']==1){ ?>
                                                            <option selected value="1"> Разработчик </option>
                                                        <?}?>
                                                        <?
                                                        $get = mysqli_query($db, " SELECT * FROM ws_user_group WHERE id <> 1 ");
                                                        while($langSite = mysqli_fetch_assoc($get)){
                                                            ?>
                                                            <option <?if($langSite['id']==$Elem['usergroup']){echo "selected";}?> value="<?=$langSite['id']?>"><?=$langSite['name']?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3">  <?=$GLOBALS['CPLANG']['LANG_CONTENT']?> <b class="red">*</b></label>
                                                <div class="col-sm-6">
                                                    <select required name="lang" class="form-control input-sm">
                                                        <?
                                                        $get = mysqli_query($db, " SELECT * FROM ws_site_languages ");
                                                        while($langSite = mysqli_fetch_assoc($get)){
                                                            ?>
                                                            <option <?if($langSite['code']==$Elem['lang']){echo "selected";}?> value="<?=$langSite['code']?>"><?=$langSite['title']?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3"> <?=$GLOBALS['CPLANG']['LANG_INTERFACE']?> <b class="red">*</b></label>
                                                <div class="col-sm-6">
                                                    <select required type="text" name="interface_lang" class="form-control input-sm">
                                                        <?
                                                        $get = mysqli_query($db, " SELECT * FROM ws_inteface_lang ");
                                                        while($langSite = mysqli_fetch_assoc($get)){
                                                            ?>
                                                            <option <?if($langSite['code']==$Elem['interface_lang']){echo "selected";}?> value="<?=$langSite['code']?>">
                                                                <?=$langSite['title']?>
                                                            </option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
                                                <div class="col-sm-10">
                                                    <img style="max-width: 300px;" src="<?=$_params['image'].$Elem['image']?>" />
                                                    <input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />
                                                </div>
                                            </div>
                                            <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'], '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="col-sm-3">
                                                    <?=$GLOBALS['CPLANG']['COLOR_THEME']?> <b class="red">*</b>
                                                </label>
                                                <div class="col-sm-6">
                                                    <select required type="text" name="skin" class="form-control input-sm">
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

                                            <h3> <?=$GLOBALS['CPLANG']['CHANGE_PASSWORD']?> </h3>
                                            <? // editElem('newpass', $GLOBALS['CPLANG']['NEW_PASSWORD'], '1', '',  '', 'add', 0, 4 ); ?>
                                            <? // editElem('newpassrepeat', $GLOBALS['CPLANG']['REPEAT_NEW_PASS'], '1', '',  '', 'add', 0, 4 ); ?>

                                            <div class="form-group">
                                                <label class="col-sm-3"> <?=$GLOBALS['CPLANG']['PASSWORD']?> <b class="red">*</b> </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon" style="cursor: pointer" onclick="gen_password(10,'newpass')" title="Сгенерировать пароль">
                                                            <i class="fa fa-fw fa-refresh"></i>
                                                        </div>
                                                        <input type="text" readonly class="form-control" name="newpass" id="newpass">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <?=$GLOBALS['CPLANG']['COMPLICITED_PASSWORD']?>:
                                                <span id="indicator"> <?=$GLOBALS['CPLANG']['NOT']?> </span>
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
    endif;
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
