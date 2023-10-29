<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include("settings.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
if( $User->InGroup($_params['access']))
{
    include_once $_SERVER['DOCUMENT_ROOT'].'/'. WS_PANEL .'/include/CMysqlBackUp.class.php';
    $Backup=new CMysqlBackUp(); 
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
?>

    <div class="content-wrapper">
            <section class="content-header">
                <h1 class="pull-left"><?=$_params['title']?></h1> 
                <div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="?add="> <i class="fa fa-user-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>
                <div class="both"></div>
            </section>

            <section class="content">
				<?
				    if(isset($_GET['add']))
				    {
				        $dateNameFile = 'new_backup_'.$dateName;
	                    CreateDump( $dateNameFile ); 
	                    
				        $res = mysqli_query($db, "INSERT INTO ".$_params['table']."
				        	(user_id,title,add_date) 
				        	VALUES
				        	(".$User->GetID().",'".$dateNameFile.".sql', NOW())");
				        if( $res ){
		                    copy(
		                        $_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/service/backup/mysql/".$dateNameFile.".sql",
		                        $_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/settings/backup_mysql/dump/".$dateNameFile.".sql"
		                        );
		                    chmod($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/settings/backup_mysql/dump/".$dateNameFile.".sql", 0600);
					     	?>
					     		<script>location.href="<?=$_SERVER['HTTP_REFERER']?>";</script>
					     	<?
						}else{
							?>
								<div class="alert alert-danger"><?=$GLOBALS['CPLANG']['ERROR_OCCURED']?></div>
							<?
						}
				    }  
	
				    if(isset($_GET['delete_id']))
				    {
				        $Backup->DeleteDump( $_GET['delete_name'] );
				        mysqli_query($db , "DELETE FROM ".$_params['table']." WHERE id = '".intval($_GET['delete_id'])."' " );   
				        ?>
				     	<script>location.href="<?=$_SERVER['HTTP_REFERER']?>";</script>
				     	<?
				    }

			    ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                
                            </div>
                            <div class="box-body table-responsive no-padding"> <?
                                ?>
                                <table class="table table-hover table-striped dataTable">
                                    <tr>
                                        <th width="30"> <?=$GLOBALS['CPLANG']['ID_WORD']?> </th>
                                        <th> <?=$GLOBALS['CPLANG']['CREATED_WORD']?>  </th> 
                                        <th> <?=$GLOBALS['CPLANG']['VIEW_WORD']?>  </th>
                                        <th class="actioncolumn" style="text-align: center"> 
                                        	<?=$GLOBALS['CPLANG']['ACTIONS']?>  
                                        </th>
                                    </tr>
                                    <?
                                    // Постраничная навигация
                                    $query = "SELECT id FROM `".$_params['table']."` "; 
                                    $Paginator = pagination($query, $_params['num_page']); 

                                    $subcatalog = mysqli_query( $db , "SELECT * 
                                    	FROM `".$_params['table']."` 
                                    	ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
										
                                    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
                                        $listAct = 'label-success';
                                        
										
                                    ?>
                                        <tr>
                                            <td align="center" class="title_line"><?=$Elem['id']?></td>
                                            <td class="title_line">
                                                <b><?=$Elem['add_date']?></b> 
                                            </td>
                                            <td align="left" class="title_line">
                                            	<a href="dump/<?=$Elem['title']?>"><?=$Elem['title']?></a>
                                            </td>
                                            <td align="center" width="210">
                                                <div class="btn-group wgroup">
                                                    <?if( $User->InGroup($_params['access_delete']) ):?>
                                                    <a href="?delete_id=<?=$Elem['id']?>&delete_name=<?=$Elem['title']?>" class="btn btn-default btn-danger" onclick="return confirm('Удалить?')">
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
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>	
