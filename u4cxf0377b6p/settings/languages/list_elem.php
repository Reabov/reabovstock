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
				<h1><?=$_params['title']?></h1>

				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php">
                    	<i class="fa fa-plus"></i> 
                    	<?=$GLOBALS['CPLANG']['ADD_ELEM']?> 
                    </a>

                    <?
                    $getLang = $Db->getall(" SELECT `code`,`title` FROM ws_site_languages WHERE active = 1 ");
                    if(count($getLang)>1){
                        ?>
                        <a class="btn btn-default btn-xs size14" onclick="$('.blockChangeHomeLang').toggle()">
                            <?=$GLOBALS['CPLANG']['CHANGE_HOME_LANG']?>
                        </a>
                        <?
                    } ?>
                </div>

                <div style="clear: both"></div>

                <?
                if(isset($_POST['change_lang'])){
                    if(isset($_POST['sel_lang'])){

                        $upd = $Db->q("UPDATE `ws_site_languages` SET `is_default`= 0  ");
                        $upd = $Db->q("UPDATE `ws_site_languages` SET `is_default`= 1 WHERE code = '". $_POST['sel_lang'] ."' ");


                        $oldLang = $Db->getone(" SELECT * FROM ws_cpu WHERE page_id = 1 AND cpu = '/' ");
                        $upd = $Db->q("UPDATE `ws_cpu` SET `cpu`= '' WHERE cpu = '/' ");

                        // получаем запись старого языка который главный
                        $AllCpu = $Db->getall(" SELECT * FROM ws_cpu WHERE page_id = 1 ");
                        foreach ($AllCpu AS $ff => $data){
                            if( $_POST['sel_lang'] == $data['lang'] ){
                                $arrURL[ $data['lang'] ] = '/';
                            }
                            else {
                                if($oldLang['lang'] == $data['lang']) { $data['cpu'] = $data['cpu'] . $data['lang']; }
                                $arrURL[ $data['lang'] ] = $data['cpu'];
                            }
                        }

                        $arrURL = $CCpu->controlURL($arrURL);
                        $arrURL = $CCpu->regionURL($arrURL);
                        //$arrURL = $CCpu->controlMainPageURL($arrURL);
                        $arrURL = $CCpu->regionURL($arrURL);
                        $CCpu->updateCpu($arrURL, 1);

                        ?>
                        <div class="alert alert-success">
                            <div><i class="icon fa fa-check"></i> <?=$GLOBALS['CPLANG']['DATA_UPDATED']?> </div>
                        </div>
                        <?
                    }
                    else {
                        echo getErrorMessage(array('title'=> $GLOBALS['CPLANG']['ERROR_OCCURED'] ));
                    }
                }
                ?>

                <div class="blockChangeHomeLang" style="display: none">
                    <form action="" method="post">
                        <div class="nav-tabs-custom">
                            <div class="tab-content form-horizontal">
                                <div class="tab-pane active" id="tab_1">
                                    <?
                                    $getLang = $Db->getall(" SELECT `code`,`title` FROM ws_site_languages WHERE active = 1 ");
                                    foreach ($getLang AS $eee => $lang){
                                        $AllCpu = $Db->getall(" SELECT * FROM ws_cpu WHERE page_id = 1 AND lang = '". $lang['code'] ."' ");
                                        foreach ($AllCpu AS $ff => $data){
                                            ?>
                                            <div class="form-group">
                                                <label class="col-sm-3"> <?=ucfirst($data['lang'])?> </label>
                                                <div class="col-sm-8">
                                                    <?=$GLOBALS['CPLANG']['IS_HOME']?> <input type="radio" name="sel_lang" <? if($data['cpu']=='/'){ ?> checked disabled <?}?> value="<?=$data['lang']?>">
                                                </div>
                                            </div>
                                            <?
                                        } ?>
                                        <?
                                    } ?>

                                    <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="change_lang">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="both"></div>
			</section>

			<section class="content">

				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								
							</div>
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-striped dataTable">
									<tr>
										<th width="30"> <?=$GLOBALS['CPLANG']['ID_WORD']?>  </th>
								        <th><?=$GLOBALS['ar_define_langterms']['MSG_ADM_TITLE']?></th> 
								        <th class="actioncolumn"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_ACTIONS']?></th>
									</tr>
									<?
									// Постраничная навигация
								    $query = "SELECT id FROM `".$_params['table']."` "; 
								    $Paginator = pagination($query, $_params['num_page']); 

							        $subcatalog = mysqli_query( $db ,"SELECT * 
							        	FROM `".$_params['table']."` 
							        	ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
										
								    while ( $Elem = mysqli_fetch_array($subcatalog) ){
								        $listAct = 'label-success';
                                        if($Elem['active']==0){
                                            $listAct = 'label-default';
                                        }
								        ?>
								        <tr class="<?if($Elem['active']==0){?>disabled<?}?>">
								            <td align="center"><?=$Elem['id']?></td>
								            <td>
								            	<b><?=$Elem['title']?> (<?=$Elem['code']?>)</b> 
								            </td>
								            <td align="center" width="210">
												<div class="btn-group wgroup">
													<?if( $User->InGroup($_params['access_delete'])  ):?>
													<a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
							                			<i class="glyphicon glyphicon-refresh"></i>
							                		</a>
							                		<?endif?>
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['ar_define_langterms']['MSG_ADM_EDIT']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                	</div>
								            </td>
								        </tr>
								        <?
								    }
							        ?>
								</table>
							</div>
						</div>
					</div>
				</div>
                <?
                paginate($Paginator);  
                ?>
			</section>

		</div>

    
    <? 
    
    ?>  
      

    
    
    <? 
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>