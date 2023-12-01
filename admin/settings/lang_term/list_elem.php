<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){ 
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
    
    $key = '';
    if(isset($_GET['key'])){
        $key = filter_var(trim($_GET['key']), FILTER_SANITIZE_SPECIAL_CHARS);
        $key = str_replace("`", "", $key);
    }
    ?>
    
        <div class="content-wrapper">
            <section class="content-header">
            	<?
                if( $User->InGroup( array( 1 ) ) )
                {
                    if($id>0)
                    {
                        $getEL = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id = ".$id);
                        $Elparent = mysqli_fetch_assoc($getEL);

                        ?>
                        <div class="btn-group backbutton">
                            <a class="btn btn-block btn-info btn-xs" href="list_elem.php?id=<?=$Elparent['section_id']?>"> <?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                        </div>
                        <div class="both"></div>

                        <h1 class="pull-left"> <?=$Elparent['title_'.$Admin->lang]?> </h1>

                        <div class="btn-group wgroup pull-right size13">
                            <a class="btn btn-default btn-xs size14" href="add_elem.php?id=<?=$id?>">
                                <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?>
                            </a>
                        </div>

                        <div class="both"></div>
                    <?
                    }
                    else
                    {
                        ?>
                        <h1 class="pull-left"> <?=$_params['title']?> </h1>
                        <div class="btn-group wgroup pull-right size13">
                            <a class="btn btn-default btn-xs size14" href="add_section.php?id=<?=$id?>">
                                <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?>
                            </a>
                        </div>
                        <div class="both"></div>
                        <?
                    }
                }
                ?>
            </section>

            <section class="content">
                <?if( $id >0 ){?>
	                <div class="box">
	                    <div class="box-body">
	                        <form method="get">
	                            <input type="hidden" name="id" value="<?=$id?>" />
	                        <div class="row">
	                            <div class="col-lg-4">
	                                <input type="text" name="key" required class="form-control input-sm"/>
	                            </div>
	                            <div class="col-lg-4 ">
	                                <button type="submit" class="btn btn-primary btn-sm">
	                                    <i class="glyphicon glyphicon-search"></i> <?=$GLOBALS['CPLANG']['SEARCH_WORD']?>
	                                </button> 
	                            </div>
	                        </div>
	                        </form>
	                    </div>
	                </div>
                <?}?>
                
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
                                        <th> <?=$GLOBALS['CPLANG']['TITLE']?> </th> 
                                        <th> <?=$GLOBALS['CPLANG']['CODE']?> </th>
                                        <th class="actioncolumn" style="text-align: center"> <?=$GLOBALS['CPLANG']['ACTIONS']?> </th>
                                    </tr>
                                    <?
                                    $keyCondition = "";
                                    if( $key!='' ){
                                        $keyCondition = array();
                                        foreach ($User->langs as $language => $value) {
                                            $keyCondition[]=" title_".$language." LIKE '%".$key."%' ";
                                        }
                                        $keyCondition = " AND ( `code` LIKE '%".$key."%' OR  ".implode(" OR ", $keyCondition).") ";
                                    }
                                    // Постраничная навигация
                                    $query = "SELECT id FROM `".$_params['table']."` WHERE section_id = ".$id." AND edit_by_user = 1 ".$keyCondition; 
                                    $Paginator = pagination($query, $_params['num_page']); 

                                    $subcatalog = mysqli_query($db, "
                                    SELECT * FROM `".$_params['table']."` WHERE section_id = ".$id." AND edit_by_user = 1 ".$keyCondition." 
                                    ORDER BY `id` ASC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']); 
                                    
                                    
                                    while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
                                        ?>
                                        <tr>
                                            <td align="center" class="title_line"><?=$Elem['id']?></td>
                                            <td class="title_line">
                                                <?=$Elem['title_'.$Admin->lang]?>
                                            </td>

                                            <td align="left" class="title_line">
                                            	
                                                <?
	                                                if( $User->InGroup( array( 1 ) ) ){
	                                                    ?> 
	                                                    <div class="codeBlock">
		                                                    <div id="<?=uniqid()?>" class="php_code" style="font-family: Consolas, Courier">
		                                            			<?echo"$";echo"GLOBALS['ar_define_langterms']['".$Elem['code']."']<br>";?>
		                                            		</div>
															<div id="<?=uniqid()?>" class="html_code" style="font-family: Consolas, Courier">
																<?echo"&lt;?=$";echo"GLOBALS['ar_define_langterms']['".$Elem['code']."']?&gt;<br>";?>
															</div>
															<br>
															<div style="position: absolute;bottom: 3px;" class="notific"> </div>
	                                                     </div>
	                                                    <?
	                                                }else{
	                                                    echo $Elem['comment'];
	                                                }
                                                ?>
                                                
                                            </td>
                                            <td align="center" width="210">
                                                <div class="btn-group wgroup">
                                                    <?if($id==0){?>
                                                    <a href="?id=<?=$Elem['id']?>" class="btn btn-default" title="<?=$GLOBALS['CPLANG']['LIST_ELEMENTS']?>">
                                                        <i class="glyphicon glyphicon-folder-open"></i>
                                                    </a>
                                                    <?}?>
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
                <?
                paginate($Paginator);  
                ?>
            </section>

        </div>

    
    
    
    
    <? 
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>