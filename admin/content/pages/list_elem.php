<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");

    if( $User->InGroup( $_params['access'] ) ){ 
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
								<table class="table table-hover">
									<tr>
										<th> 
											<?=$GLOBALS['CPLANG']['TITLE']?>
										</th>
										<th class="actioncolumn" align="center" style="text-align: center">
											<?=$GLOBALS['CPLANG']['ACTIONS']?>
										</th>
									</tr>
									<?
									// Постраничная навигация
							        $query = "SELECT id FROM `".$_params['table']."` WHERE edit_by_user = 1 ";
							    	$Paginator = $CCpu->pagination($query, $_params['num_page']);

							        $ar_pages = mysqli_query($db,
							        "SELECT * FROM `".$_params['table']."` WHERE `edit_by_user`='1' ORDER BY id DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
							        while ( $Elem = mysqli_fetch_assoc($ar_pages) )
							        { 
							            ?>
							            <tr>
							                <td class="title_line">
							                    <?=$Elem['title_'.$Admin->lang]?><br>
							                </td>
							                <td align="center">
							                	<div class="btn-group wgroup">
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                		<?/* if( $User->InGroup($_params['access_delete']) && $Elem['page'] === '/text_page.php' ): */?>
							                		<?/* endif; */?>
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