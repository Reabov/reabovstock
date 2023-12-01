<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
	$db_element = mysqli_query($db, "SELECT * FROM `ws_categories_elements` WHERE id='".$_GET['elem_id']."'");
    $ParentElem = mysqli_fetch_assoc($db_element);
    ?>
    
    <div class="content-wrapper">
			<section class="content-header">
				<h1><?=$_params['title']?></h1>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php?elem_id=<?=$_GET['elem_id']?>"> <i class="fa fa-plus"></i> Add Size</a>
                </div>
                <div class="both"></div>
                <div class="btn-group backbutton">
                	<a class="btn btn-block btn-info btn-xs" href="../list_elem.php?section_id=<?=$ParentElem['section_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?></a>
				</div>
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
										<th>Title</th>
								        <th><?=$GLOBALS['CPLANG']['IMAGE']?></th>
                                        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									$query = "SELECT id FROM `".$_params['table']."` WHERE elem_id = ".$_GET['elem_id'];
								    $Paginator = pagination($query, $_params['num_page']); 

							        $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."` WHERE elem_id = ".$_GET['elem_id']." ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
								    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
								        $listAct = 'label-success';
                                        if($Elem['active']==0){
                                            $listAct = 'label-default';
                                        }
								        ?>
								        <tr class="<?if($Elem['active']==0){?>disabled<?}?>">
								            <td align="center">
								                <?=$Elem['id']?>
							                </td>
							            	<td>
								            	<b>
								            		<?=$Elem['title_'.$Admin->lang]?>
								            	</b> 
								            </td>
								            <td align="left">
								            	<img class="imgpreview" src="<?=$_params['image'].$Elem['image']?>">
								            </td>
								            <td align="center" width="210">
												<div class="btn-group wgroup">
													<a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
							                			<i class="glyphicon glyphicon-refresh"></i>
							                		</a>
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                		<?if( $User->InGroup($_params['access_delete'])  ):?>
							                		<a onclick="return confirm('<?=$GLOBALS['CPLANG']['SURE_TO_DELETE']?>')" href="delete_elem.php?id=<?=$Elem['id']?>" class="btn btn-default btn-danger">
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
                <?
                paginate($Paginator);  
                ?>
			</section>

		</div>

    
    <? 
    
    ?>  
      

    
    
    <? 
    
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>