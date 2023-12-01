<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup(1) && in_array($User->user_id, array(1)) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
        ?>
        <div class="content-wrapper">
			<section class="content-header">
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_BACK']?> (<?=$_params['title']?>)</a>
				</div>
                <?/*
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> <?=$GLOBALS['ar_define_langterms']['MSG_ADM_ADD']?> </a>
                </div>*/ ?>
                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        $active = checkboxParam('active');
                        $access = implode(",", $ar_clean['access']);
				        
				        // 'active'=>$active,'access'=>$access
				        updateElement($id, $_params['table'], array());

				    }
                    
                    /* === */
                    
                    if( isset( $_POST['param'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
                        $getIfNotExist = mysqli_query($db,"SELECT id FROM ws_menu_admin_settings WHERE section_id = ".$id." AND param = '".$ar_clean['param']."'");
                        if( mysqli_num_rows($getIfNotExist) === 0){
                            addElement("ws_menu_admin_settings");
                        }else{
                            ?>
                            <div>
                              <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i> Ошибка!</h4>
                                Параметр <?=$ar_clean['param']?> уже существует для этого раздела!
                              </div>
                            </div>
                            <?
                        }
                    }
                    
                    /* === */
                    
                    
                    if( isset( $_POST['ok2'] ) ){
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS); 
                        foreach( $ar_clean as $code=>$ar_value ){ 
                            if( $code != "ok2" ){
                                $set_settings = mysqli_query($db," UPDATE `ws_menu_admin_settings` SET `param`='".$ar_value['param_name']."', `value`='".$ar_value['param_val']."' WHERE `param`='".$code."' AND section_id = ".$id);
                                if($set_settings){
                                    ?>
                                    <div class="direct-chat-msg inline-block">
                                        <img class="direct-chat-img" src="/<?=WS_PANEL?>/templates/lte/dist/img/users/<?=$Admin->image?>" alt="Message User Image">
                                      <div class="direct-chat-text">
                                        Параметр <code><?=$code?></code> успешно обновлен!
                                      </div>
                                    </div>
                                    <?
                                }
                            }
                        } 
                    }

                    /* === */
                    if( isset( $_POST['deleteparam'] ) ){
                        mysqli_query($db," DELETE FROM ws_menu_admin_settings WHERE id = ".(int)$_POST['deleteparam'] );
                        ?>
                        <div>
                          <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Свершилось!</h4>
                            Вы удалили ненавистный параметр!
                          </div>
                        </div>
                        <?
                    }
                    


                    $db_element = mysqli_query($db,"SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);

					?>
				</div>
				
				<h1><i><?=$Elem['title']?></i></h1>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="">
							<form method="post" enctype="multipart/form-data">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content form-horizontal">
                                        <div class="tab-pane active" id="tab_1">
                                            <? // editElem('active', $GLOBALS['ar_define_langterms']['MSG_ADM_ACTIVE'], '3', $Elem, '', 'edit' ); ?>

                                            <?/*<div class="form-group">
                                                <label for="exampleInputEmail1" class="col-sm-3">
                                                    Доступ
                                                </label>
                                                <div class="col-sm-4">
                                                    <select multiple name="access[]" required class="form-control input-sm">
                                                        <?
                                                        $accessArr = explode(",", $Elem['access']);
                                                        $getGroups = mysqli_query($db,"SELECT * FROM ws_user_group ORDER BY id ASC");
                                                        while($Group = mysqli_fetch_assoc($getGroups)){
                                                            ?>
                                                            <option <?if(in_array($Group['id'], $accessArr)){echo "selected";}?> value="<?=$Group['id']?>"><?=$Group['name']?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> */?>

                                            <? // if($Elem['section_id']==0){ editElem('image', $GLOBALS['ar_define_langterms']['MSG_ADM_CHANGE_IMAGE'], '1', $Elem,  '', 'edit', 1, 2 ); } ?>
                                            <? editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>
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
				
				

				<section class="content-header" style="padding: 30px 0 20px 0;">
                    <h1 class="float-left"><i> Params </i></h1>
                    <div class="btn-group wgroup pull-right size13">
                        <a onclick="$('#addmodal').fadeIn(200)" class="btn btn-default btn-xs size14" > <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                    </div>
                    <div class="both"></div>
                    
                    <div class="example-modal">
                        <form method="post">
                            <input type="hidden" name="section_id" value="<?=$id?>" />
                            <div class="modal" id="addmodal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span onclick="$('#addmodal').fadeOut(500)" aria-hidden="true">×</span></button>
                                            <h4 class="modal-title"> Добавить параметр </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <span class="text-light-blue">Укажите параметр <b class="text-red">*</b></span>
                                                <input name="param" class="form-control input-md" required />
                                            </div>
                                            <div class="form-group">
                                                <span class="text-light-blue">Укажите значение <b class="text-red">*</b></span>
                                                <input name="value" class="form-control input-md" required />
                                            </div>
                                            <div class="form-group">
                                                <span class="text-light-blue">Укажите комментарий</span>
                                                <textarea required name="comment" class="form-control input-sm"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Добавить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <form method="post" enctype="multipart/form-data">
				    <div class="row">
                        <?
                        $getSettings = mysqli_query($db," SELECT * FROM ws_menu_admin_settings WHERE section_id = ".$id);
                        while( $Setting = mysqli_fetch_assoc($getSettings) ){
                            ?>
                            <div class="col-xs-12 col-lg-6">
                                <div class="box box-default collapsed-box">
                                    <div class="box-header">
                                        <div>
                                            <p class="text-muted"><i> <?=$Setting['comment']?> (<?=$Setting['param']?>)</i>&nbsp;</p>
                                        </div>

                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"> <i class="fa fa-plus"></i> </button>

                                            <?
                                            if(!in_array($Setting['param'], $standartparams)){
                                                ?>
                                                <div class="inline-block">
                                                    <button type="button" onclick=" sendTodelete(<?=$Setting['id']?>) " class="btn btn-box-tool">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            <?}?>

                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <p class="text-light-blue">Параметр</p>
                                                <input name="<?=$Setting['param']?>[param_name]" class="form-control param" value="<?=$Setting['param']?>" <?if(in_array($Setting['param'], $standartparams)){echo "disabled";}?> >
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <p class="text-light-blue">Значение</p>
                                                <textarea style="height: 34px" name="<?=$Setting['param']?>[param_val]" class="form-control"><?=$Setting['value']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                    </div>

                    <div style="text-align: center">
                        <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok2" />
                    </div>
                </form>

			</section>
		</div>

        <form method="post" id="deleteForm">
            <input name="deleteparam" id="deleteparam" value="0" type="hidden">
        </form>

    <script>
        function sendTodelete(elem_id){
            if( !confirm('Удалить?') ){
                return false;
            }

            $('#deleteparam').val(elem_id);

            setTimeout(function(){
               $('#deleteForm').submit();
            },500);
        }

        var timer = 0;
        $('.param').on('keyup',function(el, el2){
            clearTimeout(timer);

            var val = $(this).val();
            var inpt = $(this);

            timer = setTimeout(function(){

                $('#loaderAllPage').show();
                var request = $.ajax({
                    type: "POST",
                    url: "/<?=WS_PANEL?>/ajax/",
                    data: "task=clear_name_param&val="+val,
                    success: function(msg){
                        $(inpt).val( $.trim( msg ) );
                        $('#loaderAllPage').hide();
                    }
                });
                request.done(function( msg ) { // успешно
                });
                request.fail(function( jqXHR, textStatus ) { // не успешно
                    alert('Произошла ошибка');
                    $('#loaderAllPage').show();
                });

            },700);
        });
    </script>

    <?
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>