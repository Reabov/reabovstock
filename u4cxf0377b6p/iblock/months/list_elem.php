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
							        $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."`  ORDER BY `id` ASC ");
								    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
								        ?>
								        <tr>
								            <td align="center"><?=$Elem['id']?></td>
								            <td>
								            	<b>
								            		<?=$Elem['title_'.$Admin->lang]?>
								            	</b> 
								            </td>
								            <td align="center" width="210">
												<div class="btn-group wgroup">
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
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

			</section>

		</div>

    
    <?}
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>