<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
    ?>
        <style>
    	.dateinput_container {
    		text-align: left;
    	}
    	
    	.dateinput_container input[type='button'] {
		    background-color: DodgerBlue;
		    color: #fff;
		    border: none;
		    border-radius: 10px;
		    padding: 7px 20px;
		    margin-left: 10px;
		    margin-top: 5px;
    	}
    	
    	.dateinput_container input[type='date']{
		    border: 2px solid gray;
		    border-radius: 10px;
		    padding: 5px 15px;
		    margin: 5px 10px;
    	}
    </style>

    <div class="content-wrapper">
			<section class="content-header">
				<h1><?=$_params['title']?></h1>
				

              
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<form class="dateinput_container" action="">
								     <div class="form-group">
								     	<?
								     	$page = 1;
										if(isset($_GET['page'])){
											$page = $_GET['page'];
										}
										$name = "";
										if(isset($_GET['name'])){
											$name = $_GET['name'];
										}
										$country = "";
										if(isset($_GET['country'])){
											$country = $_GET['country'];
										}
								     	?>
								     		<input name="page" value="<?=$page?>" hidden >
                                            <?/* <label class="col-sm-3">Сортировка по странам</label> */?>
                                            <div class="col-sm-2">
                                            	<label>Имя</label>
                                            	<input id="name" value="<?=$name?>" class="form-control input-sm" name="name" >
                                            </div>
                                            <div class="col-sm-2">
                                            	<label>Сортировка по странам</label>
                                                <select id="start" class="form-control input-sm" name="country">
                                                	<?$getCountries = $Db->getall("SELECT * FROM ws_country WHERE active = 1 ORDER BY sort DESC ");?>
                                                    <? foreach ( $getCountries AS $k => $county ) { ?>
                                                    <option <? if($_GET['country'] == $county['id']){?> selected <?} ?> value="<?=$county['id']?><?if (isset($_GET['start']) && (int)$_GET['start'] == $county['id']){echo 'selected';}?>"><?=$county['title_'.$CCpu->lang]?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 25px;" >
                                            	<button class="btn btn-info" >
                                            		Filter
                                            	</button>
												<span class="btn" type="button" onclick="reset()" >
													Reset
												</span>
                                            </div>
                                	</div>
								</form>
							</div>
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-striped dataTable">
									<tr>
										<th width="30">ID</th>
										<th><?=$GLOBALS['CPLANG']['IMAGE']?></th> 
							             <th>Имя Фамилия</th> 
								        <th>Емайл</th>          							   
								         <th>Страна</th> 
								        
								        <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
									</tr>
									<?
									$search_name = "";
									if(isset($_GET['name']) && $_GET['name'] != ''){
										$search_name = " full_name LIKE '%".$_GET['name']."%' ";
									}
									
									$search_country = "";
									if(isset($_GET['country']) && $_GET['country'] != ''){
										$search_country = " elem_id = '".$_GET['country']."' ";
										if($search_name != ""){
											$search_country = " AND ".$search_country;
										}
									}
									if($search_name != "" || $search_country != ""){
										$where = " WHERE ";
									}
									
									$query = "SELECT id FROM `".$_params['table']."` ".$where.$search_name.$search_country;
								    $Paginator = pagination($query, $_params['num_page']); 

							        $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."` ".$where.$search_name.$search_country." ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
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
								            <td align="left">
								            	
				                            	<img style="max-width: 100px;" src="/upload/userfiles/images/<?=$Elem['image']?>" />  
				                            
								            </td>
								            <td>
								            	<b>
								            		<?=$Elem['full_name']?>
								            	</b> 
								            </td>
								            <td> 
								            	<div>
								            		<b>
								            		<?=$Elem['email']?>
								            		</b>
								            	</div>
								            </td>
								            <td>
								            	<b>
								            		<?=$Elem['countrye']?>
								            	</b> 
								            </td>
								            <td align="center" width="210">
												<div class="btn-group wgroup">
							                		<a href="edit_elem.php?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['EDIT_ELEM']?>">
							                			<i class="glyphicon glyphicon-pencil"></i>
							                		</a>
							                		<?if( $User->InGroup($_params['access_delete'])):?>
                                                    <a 
                                                        href="delete_elem.php?id=<?=$Elem['id']?>" class="btn btn-default btn-danger" 
                                                        title="<?=$GLOBALS['CPLANG']['DELETE_ELEM']?>"
                                                        onclick="return confirm ('<?=$GLOBALS['CPLANG']['SURE_TO_DELETE']?>')"
                                                        >
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


?>
<script>
	/* function getFilterByCountry() {
		var start = $('#start').val();
		
		if(start != ''){
			location.href = location.href.split('?')[0] + '?start=' + start ;
		}else{
			location.href = location.href.split('?')[0];
		}
	} */
	
	function reset(){
		location.href = location.href.split('?')[0];
	}
</script>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>