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
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>
                <div class="both"></div>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
                           
                            <?/* <form method="get">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <input type="text" name="search" required class="form-control input-sm"/>
                                        <?
                                        foreach ($_GET as $key => $value) {
                                            if($key=='search'){continue;}
                                            ?>
                                            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-4 ">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="glyphicon glyphicon-search"></i> <?=$GLOBALS['CPLANG']['SEARCH_WORD']?>
                                        </button>

                                        <? if(isset($_GET['search']) && $_GET['search'] != '') { ?>
                                            <div class="btn-group backbutton">
                                                <a class="btn btn-block btn-info btn-xs" href="?"> <?=$GLOBALS['CPLANG']['GO_BACK']?></a>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </form> */?>

                        </div>

							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-striped dataTable">
									<tr>
										<th width="30">ID</th>
										
								        <th><?=$GLOBALS['CPLANG']['TITLE']?></th> 
								        <?/* <th><?=$GLOBALS['CPLANG']['IMAGE']?></th> */?>
								        <th>Description</th> 
								        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									$query = "SELECT id FROM `".$_params['table']."`"; 
								    $Paginator = pagination($query, $_params['num_page']); 

							        $subcatalog = mysqli_query($db,
							        "SELECT * FROM `".$_params['table']."` ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
								    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
								        $listAct = 'label-success';
                                        if($Elem['active']==0){
                                            $listAct = 'label-default';
                                        }
								        ?>
								        <tr class="<?if($Elem['active']==0){?>disabled<?}?>">
								            <td align="center" >
								            	<?=$Elem['id']?>
							                </td>
								            <td>
								            	<b>
								            		<?=$Elem['title_'.$Admin->lang]?>
								            	</b> 
								            </td>
								             <?/* <td align="left">
								            	<img class="imgpreview" src="<?=$_params['image'].$Elem['image']?>">
								            </td> */?>
								            <td align="left">
								            	 <?=$Elem['text_'.$Admin->lang]?>
								            </td>
								            <td align="center" width="310">
												<div class="btn-group wgroup">
													<a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
							                			<i class="glyphicon glyphicon-refresh"></i>
							                		</a>
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                		<a href="products/list_elem.php?section_id=<?=$Elem['id']?>" class="btn btn-default" title="Variations">
							                			<i class="fa fa-folder"></i>
							                		</a>
							                		<?if( $User->InGroup($_params['access_delete'])):?>
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
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>