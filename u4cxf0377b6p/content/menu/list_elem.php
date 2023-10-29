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
                    <a class="btn btn-default btn-xs size14" href="add_elem.php?parent=<?=$parent?>"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
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
										<th width="30">ID</th>
								        <th><?=$GLOBALS['CPLANG']['TITLE']?></th> 
								        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									    

										$subcatalog = mysqli_query($db,
										"SELECT * FROM `".$_params['table']."` WHERE section_id = ".$parent." ORDER BY `sort` DESC ");
                                        while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
                                            $listAct = 'label-success';
                                            if($Elem['active']==0){
                                                $listAct = 'label-default';
                                            }
                                            ?>
                                            <tr class="<?if($Elem['active']==0){?>disabled<?}?>">
                                                <td align="center"><?=$Elem['id']?></td>
                                                <td>
                                                    <b>
                                                        <?=$Elem['title_'.$Admin->lang]?>
                                                    </b> 
                                                </td>
                                                <td align="center" width="260">
                                                    <div class="btn-group wgroup">
                                                        <a target="_blank" class="btn btn-default" href="<?=$Elem['link_'.$Admin->lang]?>">
                                                            <i class="fa fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-default" href="?parent=<?=$Elem['id']?>">
                                                            <i class="fa fa-list"></i>
                                                        </a>
                                                        <a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
                                                            <i class="glyphicon glyphicon-refresh"></i>
                                                        </a>
                                                        <a href="edit_elem.php?id=<?=$Elem['id']?>&parent=<?=$parent?>" class="btn btn-default" title="<?=$GLOBALS['ar_define_langterms']['MSG_ADM_EDIT']?>">
                                                            <i class="glyphicon glyphicon-pencil"></i>
                                                        </a>
                                                        <?if( $User->InGroup($_params['access_delete'])  ):?>
                                                        <a 
                                                            onclick="return confirm('<?=$GLOBALS['ar_define_langterms']['MSG_ADM_SURE_TO_DELETE']?>')" 
                                                            href="delete_elem.php?id=<?=$Elem['id']?>&parent=<?=$parent?>" class="btn btn-default btn-danger" 
                                                            title="<?=$GLOBALS['ar_define_langterms']['MSG_ADM_EDIT']?>">
                                                            <i class="glyphicon glyphicon-remove-circle wglyph"></i>
                                                        </a>
                                                        <?endif;?>
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
			</section>

		</div>

    
    <? 
    
    ?>  
      

    
    
    <? 
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>