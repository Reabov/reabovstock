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
                <h1 class="float-left"><?=$_params['title']?></h1>  
               <? /* <div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> 
                    	<i class="fa fa-plus"></i> 
                    	<?=$GLOBALS['CPLANG']['ADD_ELEM']?>  
                    </a>
                </div> */?>
                <div class="both"></div>
            </section>

            <section class="content">
                <?
                
                if( isset($_POST['ok']) ){
                    $ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                    foreach( $ar_clean as $code=>$ar_value ){
                        if( is_array($ar_value[1]) ){
                            $ar_value[1] = implode(",", $ar_value[1] );
                        }
                        $set_settings = mysqli_query($db, "UPDATE `ws_settings` 
                        	SET `description`='".$ar_value[0]."', `value`='".$ar_value[1]."' WHERE `code`='".$code."'");
                        
                    }
                    ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?=$GLOBALS['CPLANG']['SETTING_CHANGE']?> 
                    </div>
                    <?
                }
                
                ?>
                <div class="row">
                    <form method="post" action="">
	                    <?
	                    $getSettings = mysqli_query($db, " SELECT * FROM ws_settings WHERE active = 1 ORDER BY sort DESC  ");
	                    while( $Setting = mysqli_fetch_assoc($getSettings) ){
	                        ?>
	                        <div class="col-xs-12">
	                            <div class="box box-default">
	                                <div class="box-header with-border">
	                                    <h3 class="box-title"><?=$Setting['title']?></h3>
	                                   
	                                </div>
	                                <div class="box-body">
	                                    <div class="row">
	                                        <div class="col-lg-6 col-md-12">
	                                            <p class="text-light-blue"> <?=$GLOBALS['CPLANG']['COMMENT']?> </p>
	                                            <textarea name="<?=$Setting['code']?>[]" class="form-control"><?=$Setting['description']?></textarea>
	                                        </div>
	                                        <div class="col-lg-6 col-md-12">
	                                            <p class="text-light-blue"> <?=$GLOBALS['CPLANG']['ENTRY_VALUE']?> </p>
	                                            <textarea name="<?=$Setting['code']?>[]" class="form-control"><?=$Setting['value']?></textarea>
	                                        </div>
	                                    </div>
	                                    
	                                    <?if( $User->InGroup( 1 ) ){ ?>
	                                    	<div class="codeBlock">
			                                    <div id="<?=uniqid()?>" class="php_code" style="font-family: Consolas, Courier;margin-top: 10px;">
			                            			<?echo"$";echo"GLOBALS['ar_define_settings']['".$Setting['code']."']<br>";?>
			                            		</div>
												<div id="<?=uniqid()?>" class="html_code" style="font-family: Consolas, Courier">
													<?echo"&lt;?=$";echo"GLOBALS['ar_define_settings']['".$Setting['code']."']?&gt;<br>";?>
												</div>
												<br>
												<div style="position: absolute;bottom: 3px;" class="notific"> </div>
	                                    	</div>
	                                    <?}?>
		                                    
	                                    
	                                </div>
	                            </div>
	                        </div>
	                        <?
	                    }
	                    ?>
	                    <div style="text-align: center">
	                        <input type="submit" class="btn btn-primary btn-lg" value="Сохранить" name="ok" />
	                    </div>
                    </form>
                </div>
            </section>

        </div>

    
    <? 
    
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");?>