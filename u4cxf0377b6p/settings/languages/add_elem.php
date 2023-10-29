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
                <div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php"> <?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    //обработка запроса
                    if( isset( $_POST['ok'] ) ){
                    	
                        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
						//массив с икслючениями
				        $exceptions = array();
						$allQueries = array();
				        
				        // полуим список таблиц
				        $getTables = mysqli_query( $db , " SHOW TABLES  ");
						while( $Table = mysqli_fetch_array($getTables) ){
							
							if( in_array($Table[0], $exceptions) ){
								continue;
							}
							
							$queryDeuplicate = array();
							$queryContent = array();
							//получим список полей
							$getColumns = mysqli_query( $db , " SHOW COLUMNS FROM ".$Table[0] );
							while($Column = mysqli_fetch_assoc($getColumns)){
								$a = explode("_", $Column['Field']);
								if( end($a) == $_POST['from_lanuage'] ){ // для этого поля нужно сделать копию
									$newName = str_replace("_".$_POST['from_lanuage'], "_".$_POST['new_prefix'], $Column['Field']); 
									// возможно изменить на вариант с обрезкой последних сомволов
									$Type = strtoupper($Column['Type']);
									$queryDeuplicate[]=" ADD `".$newName."` ".$Type." NOT NULL ";
									$queryContent[]=" `".$newName."` = `".$Column['Field']."` ";
								}
							} 
							
							if( !empty($queryDeuplicate) ){
								$allQueries[]=" ALTER TABLE `".$Table[0]."` ".implode(", ", $queryDeuplicate)." ";
								$allQueries[]=" UPDATE `".$Table[0]."` SET  ".implode(", ", $queryContent)." ";
							}
				
						}
						
						foreach ($allQueries as $key => $value) {
							mysqli_query( $db , $value); 
						}
						
						//а теперь добаим адреса в ws_cpu
						$counter = 50; //по 50 штук в запросе
						$arCpuCopy = array();
						$getForCopy = mysqli_query( $db , " SELECT * FROM ws_cpu WHERE `lang` = '".$_POST['from_lanuage']."' ");
						while( $Cpu = mysqli_fetch_assoc($getForCopy) ){
							$counter++; 
							$uniqCode = "/".file_name(12)."/";
							$arCpuCopy[]=" ('".$Cpu['page_id']."','".$uniqCode."','".$_POST['new_prefix']."','".$Cpu['elem_id']."') ";
							if(count($arCpuCopy)>=50){
								$newUrl = mysqli_query( $db , " INSERT INTO ws_cpu (`page_id`,`cpu`,`lang`,`elem_id`) 
								VALUES  ".implode(", ", $arCpuCopy)."   ");
								$arCpuCopy = array();
							}
						}
                        
                        if(count($arCpuCopy)>=0){
                            $newUrl = mysqli_query( $db , " INSERT INTO ws_cpu (`page_id`,`cpu`,`lang`,`elem_id`) 
                            VALUES  ".implode(", ", $arCpuCopy)." ");
                            $arCpuCopy = array();
                        }
						
						// добамис язык
						$addLang = mysqli_query( $db , " INSERT INTO ws_site_languages (`code`,`title`) 
							VALUES ('".$_POST['new_prefix']."','".$_POST['new_title']."') ");
						
						// и запишем в настройки
						$getCurrentLangs = mysqli_query( $db , " SELECT * FROM ws_site_languages ORDER BY sort DESC");
						while($currLang = mysqli_fetch_assoc($getCurrentLangs)){
							$ar_lang[]=$currLang['code'];
						}
						$updateSettings = mysqli_query( $db , " UPDATE ws_settings SET `value` = '".implode(",", $ar_lang)."' WHERE `code` = 'LANG_SITE' ");
						
						?>
						<div class="alert alert_success"> <?=$GLOBALS['CPLANG']['LANG_ADDS_SUCCESS']?> </div> 
						<?
						
                    }
                    ?>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="">
                            <form method="post" enctype="multipart/form-data">
                            	
	                            <div class="box">
	                            	<div class="box-body form-horizontal">
	                            		
	                            		<div class="form-group">
	        								<label for="exampleInputEmail1" class="col-sm-3"> 
	        									<?=$GLOBALS['CPLANG']['LANGUAS_FOR_COPY']?>  
	        									<b class="red">*</b></label>
	                            			<div class="col-sm-4">
	                                            <select required="" type="text" name="from_lanuage" class="form-control input-sm">
	                                                <option value=""> --- </option>
	                                                <?
	                                                	$getLangs = mysqli_query( $db , " SELECT * 
	                                                		FROM ws_site_languages WHERE active = 1 ORDER BY sort DESC ");
														while( $Langs = mysqli_fetch_assoc($getLangs) ){
	                                                ?>
	                                                	<option value="<?=$Langs['code']?>"><?=$Langs['title']?></option>
	                                                <?}?>
	                                               
	                                            </select>
	               	 					    </div>
	    								</div>
	                            		
	                            		<? editElem('new_prefix', $GLOBALS['CPLANG']['CODE_NEW_LANG'] , '1', '',  '', 'add', 1, 2); ?>
	                            		
	                            		<? editElem('new_title', $GLOBALS['CPLANG']['NAME_NEW_LANG'] , '1', '',  '', 'add', 1, 4); ?>
	                            		
	                            	</div>
	                            </div>
	                            
	                            <div style="text-align: center">
	                                <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
	                            </div>
	                            
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
              
            <?

}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>