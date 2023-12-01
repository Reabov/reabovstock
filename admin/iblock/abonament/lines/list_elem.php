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
            <div class="btn-group backbutton">
                <a class="btn btn-block btn-info btn-xs" href="../list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> </a>
            </div>
            <div class="btn-group wgroup pull-right size13">
                <a class="btn btn-default btn-xs size14" href="add_elem.php?section_id=<?=$_GET['section_id']?>">
                    <i class="fa fa-plus"></i>
                    <?=$GLOBALS['CPLANG']['ADD_ELEM']?>
                </a>
            </div>
            <div class="both"></div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-header">
                            <?
                            $fieldToSearch = array();
                            if(isset($_GET['search']) && $_GET['search'] != '') {
                                $colums = $Db->getall(" select *  from information_schema.columns where table_schema = '" . $DB_NAME . "'  and table_name = '" . $_params['table'] . "' ");
                                foreach ($colums as $ee => $data) {
                                    $haystack = $data['DATA_TYPE'];
                                    $needle = 'varchar';
                                    $pos = strripos($haystack, $needle);

                                    $needle = 'text';
                                    $pos2 = strripos($haystack, $needle);

                                    if ($pos !== false || $pos2 !== false) {
                                        $fieldToSearch[] = " `".$data['COLUMN_NAME']."` LIKE '%". trim( $_GET['search'] ) ."%' ";
                                    }
                                }
                            }


                            $query = "SELECT id FROM `".$_params['table']."` WHERE ab_id = '". $_GET['section_id'] ."' ";

                            if( !empty( $fieldToSearch ) ) {
                                $fieldToSearch = " ( ". implode(" OR ", $fieldToSearch ) ." ) ";
                                $haystack = $query;
                                $needle = 'WHERE';
                                $pos = strripos($haystack, $needle);

                                $needle = 'where';
                                $pos2 = strripos($haystack, $needle);

                                if ($pos === false && $pos2 === false) {
                                    $fieldToSearch = " WHERE " . $fieldToSearch;
                                }
                                else {
                                    $fieldToSearch = " AND " . $fieldToSearch;
                                }
                            }
                            else {
                                $fieldToSearch = " ";
                            }

                            $query = " SELECT id FROM `".$_params['table']."` WHERE ab_id = '". $_GET['section_id'] ."' $fieldToSearch ";
                            $Paginator = pagination($query, $_params['num_page']);
                            ?>
                            
                        </div>

                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-striped dataTable">
                                <tr>
                                    <th width="30">ID</th>
                                    <th><?=$GLOBALS['CPLANG']['TITLE']?></th>
                                    <th style="text-align:center;" class="actioncolumn"><?=$GLOBALS['CPLANG']['ACTIONS']?></th>
                                </tr>

                                <?
                                /** менять SQL во всех переменных $query */
                                $subcatalog = mysqli_query($db,"SELECT * FROM `".$_params['table']."` 
                                WHERE ab_id = '". $_GET['section_id'] ."'  $fieldToSearch 
                                ORDER BY `id` DESC LIMIT ".$Paginator['from'].", ".$Paginator['per_page']);
                                while ( $Elem = mysqli_fetch_assoc($subcatalog) ){
                                    ?>
                                    <tr>
                                        <td align="center">
                                            <?=$Elem['id']?>
                                        </td>

                                        <td>
                                            <b><?=$Elem['title_'.$Admin->lang]?></b>
                                        </td>
                                        
                                        <td align="center" width="210">
                                            <div class="btn-group wgroup">
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
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>