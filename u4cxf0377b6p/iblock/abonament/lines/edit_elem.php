<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
    $Elem = mysqli_fetch_array($db_element);
        ?>
        <div class="content-wrapper">
			<section class="content-header">
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php?section_id=<?=$Elem['section_id']?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php?section_id=<?=$Elem['section_id']?>"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>

                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ) {

				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        
				        updateElement($id, $_params['table'], array(), array(), array(), $exceptions);
                        
				    }

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
						<div class="">
							<form method="post" enctype="multipart/form-data">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?=$GLOBALS['CPLANG']['ALLADATA']?></a></li>
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<?
					                	foreach( $Admin->ar_lang as $lang_index ){  ?>
					                    	<? editElem('title', $GLOBALS['CPLANG']['TITLE'].' ('.$lang_index.')', '1', $Elem,  $lang_index, 'edit', 1, 7 ); ?>
					                	<?}?>
									</div>
									
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