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
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>
				<div class="btn-group wgroup pull-right size13">
                    <a class="btn btn-default btn-xs size14" href="add_elem.php"> <i class="fa fa-plus"></i> <?=$GLOBALS['CPLANG']['ADD_ELEM']?> </a>
                </div>
                <div class="both"></div>
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        updateElement($id, $_params['table']);
						
 				    }
                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);
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
                                        foreach( $Admin->ar_lang as $lang_index ){  
                                            editElem('title', $GLOBALS['CPLANG']['TITLE']." (".$lang_index.")", '1', $Elem,  $lang_index, 'edit', 1, 7 );
											editElem('little_title',  "Sub title (".$lang_index.")", '1', $Elem,  $lang_index, 'edit', 0, 7 );
											editElem('text', 'Description'." (".$lang_index.")", '1', $Elem,  $lang_index, 'edit', 1, 7 );
                                        }?>						
                                        <div class="form-group">
        									<label class="col-sm-3">Точное количество дней <b class="red">*</b></label>
        									<div class="col-sm-2">
												<input type="number" name="days" value="<?=$Elem['days']?>" min="1" class="form-control input-sm">
											</div>
    									</div>			
					                    <? //editElem('from_date', 'Period-from', '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    <? //editElem('to_date','Period-to', '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    <? editElem('price','Price', '1', $Elem,  '', 'edit', 1, 2 ); ?>
					                    <? editElem('max','Max count of download', '1', $Elem,  '', 'edit', 1, 2 ); ?>
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
<script>
	$('input[name="title_en"]').keyup(function(){
		var v = $(this).val();
		if(v.length > 15){
			v = v.slice(0,15);
		}
		$(this).val(v);
	});
</script>