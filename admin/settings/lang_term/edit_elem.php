<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} 
if( $User->InGroup($_params['access']) ){
	
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

    if ( !isset($id) ):?>
       <?=$GLOBALS['ar_define_langterms']['MSG_ADM_NODATAFOREDIT']?>
    <?else:        
        $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
        if ( $Elem = mysqli_fetch_array($db_element) ){
    ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="btn-group backbutton">
                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php?id=<?=$Elem['section_id']?>"> <?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
                </div>
                
                <div>
                    <? 
                    
	                    //обработка запроса
	                    if( isset( $_POST['ok'] ) ){
	                        updateElement($id, $_params['table']);
	                        $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
	        				$Elem = mysqli_fetch_array($db_element);
	                    }
						
                    ?>
                </div>
                
                <h1><i><?=$Elem['title_'.$Admin->lang]?></i></h1>
            </section>

            <section class="content">

                <div class="row">
                    <div class="col-xs-12">

                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="nav-tabs-custom">
                                <div class="tab-content form-horizontal">
                                   <?
                                   foreach ($Admin->langs as $keyLang=> $LangInfo) {
                                       ?>
                                       <div class="row form-group">
                                       		<div class="col-lg-2 col-xs-12">
                                       			<b><?=$LangInfo['title']?></b>
                                       		</div>
                                       		<div class="col-lg-8 col-xs-12">
                                       			<textarea class="form-control" name="title_<?=$keyLang?>"><?=$Elem['title_'.$keyLang]?></textarea>
                                       		</div>
                                       </div>
                                       <?
                                   }
                                   ?>
                                   
                                   <div class="row form-group">
                                   		<div class="col-lg-2 col-xs-12">
                                   			<b> <?=$GLOBALS['CPLANG']['COMMENT']?> </b>
                                   		</div>
                                   		<div class="col-lg-8 col-xs-12">
                                   			<textarea class="form-control" name="comments"><?=$Elem['comments']?></textarea>
                                   		</div>
                                   </div>

                                </div>
                            </div>
                            <div style="text-align: center">
                                <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
                            </div>
                            
                         </form>

                    </div>
                </div>

            </section>

        </div>
              
<?
    }

    endif;
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");

?>