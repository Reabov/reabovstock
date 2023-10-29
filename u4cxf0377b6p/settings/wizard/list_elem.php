<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup(1) && in_array($User->user_id, array(1)) ){ /* доступ к мастеру настроек должен быть только у разработчика; при необходимости ид можно добавить в массив */

	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

        ?>
        <div class="content-wrapper">
			<section class="content-header">
				<h1><?=$_params['title']?></h1>
                <?/*
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> <?=$GLOBALS['ar_define_langterms']['MSG_ADM_ADD']?> </a>
                </div>*/?>
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
										<th style="width: 40px"></th>
								        <th><?=$GLOBALS['ar_define_langterms']['MSG_ADM_TITLE']?></th> 
								        <th>Доступ</th>           
								        <th class="actioncolumn"><?=$GLOBALS['ar_define_langterms']['MSG_ADM_ACTIONS']?></th>
									</tr>
									<?

							        $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."` WHERE section_id = 0 AND active = 1 ORDER BY `sort` DESC ");
								    while ( $Elem = mysqli_fetch_array($subcatalog) ){
								        $listAct = 'label-success';
                                        if($Elem['active']==0){
                                            $listAct = 'label-default';
                                        }
								        ?>
								        <tr class="<?if($Elem['active']==0){?>disabled<?}?>">
                                            <td align="center">
                                                <i class="fa <?=$Elem['image']?>"></i>
                                            </td>
								            <td>
								            	<b><?=$Elem['title']?></b> 
								            </td>
								            <td>
                                                <b>
                                                    <?
                                                    $getGG = $Db->getall(" SELECT * FROM `ws_user_group` WHERE id IN (". $Elem['access'] .") AND id <> 1 ");
                                                    foreach ($getGG AS $dd => $ttt){
                                                        echo $ttt['name'] . '<br>';
                                                    }
                                                    ?>
                                                </b>
								            </td>
								            <td align="left" width="210">
												<div class="btn-group wgroup"> <?/*
												    <a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
                                                        <i class="glyphicon glyphicon-refresh"></i>
                                                    </a>
												    <a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['ar_define_langterms']['MSG_ADM_EDIT']?>">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>*/?>
                                                    <?/*
													<a href="l" class="btn btn-info" title="Список установленных модулей">
							                			<i class="glyphicon glyphicon-folder-open"></i>
							                		</a>*/?>
							                	</div>
								            </td>
								        </tr>
								        <?
								        
								        $getSubelemets = mysqli_query($db," SELECT * FROM `".$_params['table']."` WHERE section_id = $Elem[id] AND id <> 21 AND active = 1 ORDER BY `sort` DESC ");
                                        while( $Elem2 = mysqli_fetch_assoc($getSubelemets) ){
                                            $listAct = 'label-success';
                                            if($Elem2['active']==0){
                                                $listAct = 'label-default';
                                            }
                                            ?>
                                            <tr class="<?if($Elem2['active']==0){?>disabled<?}?>">
                                                <td></td>
                                                <td>
                                                    <i><?=$Elem2['title']?></i> 
                                                </td>
                                                <td>
                                                    <b>
                                                        <?
                                                        $getGG = $Db->getall(" SELECT * FROM `ws_user_group` WHERE id IN (". $Elem2['access'] .") AND id <> 1 ");
                                                        foreach ($getGG AS $dd => $ttt){
                                                            echo $ttt['name'] . '<br>';
                                                        }
                                                        ?>
                                                    </b>
                                                </td>
                                                <td align="left" width="210">
                                                    <div class="btn-group wgroup"><?/*
                                                        <a onclick="refresh_elem(<?=$Elem2['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
                                                            <i class="glyphicon glyphicon-refresh"></i>
                                                        </a>*/?>

                                                        <a href="edit_elem.php?id=<?=$Elem2['id']?>" class="btn btn-default">
                                                            <i class="glyphicon glyphicon-pencil"></i>
                                                        </a>

                                                        <?if( $User->user_id == 1 && !in_array($Elem2['id'], array(6,12,20,13,15,16,21,9)) && 0 ):?>
                                                            <a onclick="return confirm('<?=$GLOBALS['ar_define_langterms']['MSG_ADM_SURE_TO_DELETE']?>')" href="delete_elem.php?id=<?=$Elem2['id']?>" class="btn btn-default btn-danger">
                                                                <i class="glyphicon glyphicon-remove-circle wglyph"></i>
                                                            </a>
                                                        <?endif;?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?
                                        }
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