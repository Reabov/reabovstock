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
								        <th style="text-align:center;" class="actioncolumn">Имя</th>
								        <th style="text-align:center;" class="actioncolumn">Емайл</th>
								        <th style="text-align:center;" class="actioncolumn">Дата</th>   
								        <th style="text-align:center;" class="actioncolumn">Сообщение</th>                 
								        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									$query = "SELECT id FROM `".$_params['table']."` "; 
								    $Paginator = pagination($query, $_params['num_page']); 

							        $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."`  ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
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
							                <td align="center">
                                                <?=$Elem['name']?> <?=$Elem['surname']?>
                                            </td>
                                            <td align="center">
                                                <?=$Elem['email']?>
                                            </td>
								            <td align="center">
                                                <?=$Elem['date']?>
                                            </td>
                                            <td align="center">
                                                <?=$Elem['message']?>
                                            </td>
								            <td align="center" width="210">
												<div class="btn-group wgroup">
													<a onclick="refresh_elem(<?=$Elem['id']?>, '<?=$_params['table']?>')" class="btn btn-default <?=$listAct?>">
							                			<i class="glyphicon glyphicon-refresh"></i>
							                		</a>
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="fa fa-search"></i>
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